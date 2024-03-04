<?php

namespace App\Console\Commands;

use App\Models\V1\Childcare\ConsultCcdevService;
use App\Models\V1\Childcare\ConsultCcdevVaccine;
use App\Models\V1\Childcare\PatientCcdev;
use App\Models\V1\Patient\PatientVaccine;
use Illuminate\Console\Command;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrateMisuWahChildCareCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'misuwah:migrate-cc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $databases = DB::select("SHOW DATABASES LIKE 'DOH%'");
        $databaseNames = array_map('current', $databases);
        $database = $this->choice(
            'Select database to be migrated:',
            $databaseNames
        );
        $connectionName = 'mysql_migration';
        $this->migrationConnection($connectionName, $database);

        $patientCcdev = $this->getPatientCc();
        $this->processPatientCc($patientCcdev, $database);

    }

    public function migrationConnection($connectionName, $database)
    {
        //$connectionName = 'mysql_migration'; // Replace with the name of your database connection
        $newDatabaseName = $database; // Replace with the new database name you want to use

        DB::purge($connectionName); // Clear any previous configurations for the connection

        // Retrieve the database connection configuration array
        $config = config("database.connections.$connectionName");

        // Update the 'database' parameter with the new database name
        $config['database'] = $newDatabaseName;

        // Set the updated configuration for the connection
        $connection = app(ConnectionFactory::class)->make($config);

        // Set the new connection instance for the specific connection name
        DB::connection($connectionName)->setPdo($connection->getPdo())->setReadPdo($connection->getReadPdo());
        // Add column if it doesn't exist on the 'patient' table
        // Add column if it doesn't exist on the 'patient' table
        try {
            // Add column if it doesn't exist on the 'patient' table
            Schema::connection($connectionName)->table('patient_ccdev', function (Blueprint $table) {
                $table->string('wahtermelon_ccdev_id')->nullable()->after('id');
                // Add more columns if needed
            });

        } catch (\Exception $e) {
            // Handle the exception (column already exists)
            // You can log the error or perform other actions if needed
            // For now, we'll just skip this iteration
            //continue;
        }
    }

    public function getPatientCc()
    {
        return DB::connection('mysql_migration')->table('patient_ccdev')
            ->selectRaw('
                patient_ccdev.id,
                patient_ccdev.birth_weight,
                patient_ccdev.admission_date,
                patient_ccdev.discharge_date,
                patient_ccdev.created_at,
                patient_ccdev.updated_at
            ')
            ->addSelect(
                'patient.wahtermelon_patient_id AS patient_id',
                'user.wahtermelon_user_id AS user_id',
                'mother.wahtermelon_patient_id AS mothers_id'
            )
            ->join('patient AS patient', function ($join) {
                $join->on('patient_ccdev.patient_id', '=', 'patient.id')
                    ->whereNotNull('patient.wahtermelon_patient_id');
            })
            ->leftJoin('patient AS mother', function ($join) {
                $join->on('patient_ccdev.mothers_id', '=', 'mother.id')
                    ->whereNotNull('mother.wahtermelon_patient_id');
            })
            ->join('user AS user', function ($join) {
                $join->on('patient_ccdev.user_id', '=', 'user.id')
                    ->whereNotNull('user.wahtermelon_user_id');
            })
            //->whereNull('wahtermelon_ccdev_id')
            ->whereNull('deleted_at')
            ->whereNotNull('birth_weight')
            ->get();
    }

    public function getCcServices($ccdevId)
    {
        return DB::connection('mysql_migration')->table('consult_ccdev_service')
            ->selectRaw('
                consult_ccdev_service.*,
                1 AS status_id,
                consult_ccdev_service.created_at,
                consult_ccdev_service.updated_at
            ')
            ->addSelect(
                'patient.wahtermelon_patient_id AS patient_id',
                'user.wahtermelon_user_id AS user_id'
            )
            ->join('patient AS patient', function ($join) {
                $join->on('consult_ccdev_service.patient_id', '=', 'patient.id')
                    ->whereNotNull('patient.wahtermelon_patient_id');
            })
            ->join('user AS user', function ($join) {
                $join->on('consult_ccdev_service.user_id', '=', 'user.id')
                    ->whereNotNull('user.wahtermelon_user_id');
            })
            ->whereCcdevId($ccdevId)
            ->whereDate('service_date', '>=', '0001-01-01')
            ->whereDate('service_date', '<=', '9999-12-31')
            ->get();
    }

    public function getCcVaccines($ccdevId)
    {
        return DB::connection('mysql_migration')->table('consult_ccdev_vaccine')
            ->selectRaw('
                consult_ccdev_vaccine.*
            ')
            ->addSelect(
                'patient.wahtermelon_patient_id AS patient_id',
                'user.wahtermelon_user_id AS user_id'
            )
            ->join('patient AS patient', function ($join) {
                $join->on('consult_ccdev_vaccine.patient_id', '=', 'patient.id')
                    ->whereNotNull('patient.wahtermelon_patient_id');
            })
            ->join('user AS user', function ($join) {
                $join->on('consult_ccdev_vaccine.user_id', '=', 'user.id')
                    ->whereNotNull('user.wahtermelon_user_id');
            })
            ->whereCcdevId($ccdevId)
            ->get();
    }

    /**
     * Process Patient Child Care
     *
     * @param $patientCc
     * @param $facilityCode
     * @return void
     */
    private function processPatientCc($patientCc, $facilityCode): void
    {
        $patientCcBar = $this->output->createProgressBar(count($patientCc));
        $patientCcBar->setFormat('Processing Patient Child Care Table: %current%/%max% [%bar%] %percent:3s%% Elapsed: %elapsed:6s% Remaining: %remaining:6s% Estimated: %estimated:-6s%');
        $patientCcBar->start();
        $startTime = time();

        $this->chunkAndProcess($patientCc, $facilityCode, $patientCcBar);

        $patientCcBar->finish();
        $this->displayElapsedTime($startTime);
    }

    /**
     * Chunk and Process Patient Cc Data
     *
     * @param $patientCc
     * @param $facilityCode
     * @param $patientCcBar
     * @return void
     */
    private function chunkAndProcess($patientCc, $facilityCode, $patientCcBar): void
    {
        $chunkSize = 200;
        $chunks = array_chunk($patientCc->toArray(), $chunkSize);

        foreach ($chunks as $chunk) {
            foreach ($chunk as $patientCcData) {
                $this->processPatientCcData($patientCcData, $facilityCode);
                $patientCcBar->advance();
            }
        }
    }

    /**
     * Display Elapsed Time
     *
     * @param int $startTime
     * @return void
     */
    private function displayElapsedTime(int $startTime): void
    {
        $endTime = time();
        $elapsedTime = $endTime - $startTime;
        $this->newLine();
        $this->line('Elapsed Time: ' . gmdate('H:i:s', $elapsedTime));
    }

    private function processPatientCcData($patientCcData, $facilityCode): void
    {
        DB::transaction(function () use ($patientCcData, $facilityCode) {
            $patientCcData = (array)$patientCcData;
            $patientCcData['ccdev_ended'] = 0;
            $patientCcData['facility_code'] = $facilityCode;
            //dd($patientCcData);
            $cc = PatientCcdev::query()->updateOrCreate(['patient_id' => $patientCcData['patient_id']], $patientCcData);
//            if($patientCcData['id'] == '268') {
//                dd(count($this->getCcServices($patientCcData['id'])));
//            }
            $services = $this->getCcServices($patientCcData['id']);
            if(count($services) > 0) {
                $this->saveCcServices($services, $facilityCode);
            }

            $vaccines = $this->getCcVaccines($patientCcData['id']);
            if(count($vaccines) > 0) {
                $this->saveCcVaccines($vaccines, $facilityCode);
            }

            DB::connection('mysql_migration')->table('patient_ccdev')->where('id', $patientCcData['id'])->update(['wahtermelon_ccdev_id' => $cc->id]);
        });
    }

    private function saveCcServices($services, $facilityCode)
    {
        foreach ($services as $service) {
            $service = (array)$service;
            ConsultCcdevService::query()->updateOrCreate(['patient_id' => $service['patient_id'], 'service_id' => $service['service_id'], 'service_date' => $service['service_date']], $service + ['facility_code' => $facilityCode]);
        }
    }

    private function saveCcVaccines($vaccines, $facilityCode)
    {
        foreach ($vaccines as $vaccine) {
            $vaccine = (array)$vaccine;
            PatientVaccine::query()->updateOrCreate(['patient_id' => $vaccine['patient_id'], 'vaccine_id' => $vaccine['vaccine_id'], 'created_at' => $vaccine['created_at']], $vaccine + ['facility_code' => $facilityCode]);
        }
    }
}
