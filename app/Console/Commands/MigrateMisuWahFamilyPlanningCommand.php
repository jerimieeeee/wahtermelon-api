<?php

namespace App\Console\Commands;

use App\Models\V1\FamilyPlanning\PatientFp;
use App\Models\V1\FamilyPlanning\PatientFpChart;
use App\Models\V1\FamilyPlanning\PatientFpHistory;
use App\Models\V1\FamilyPlanning\PatientFpMethod;
use App\Models\V1\FamilyPlanning\PatientFpPelvicExam;
use App\Models\V1\FamilyPlanning\PatientFpPhysicalExam;
use Illuminate\Console\Command;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrateMisuWahFamilyPlanningCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'misuwah:migrate-fp';

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

        $patientFp = $this->getPatientFp();
        $this->savePatientFp($patientFp, $database);
        //$patientCcdev = $this->getPatientCc();
        //$this->savePatientCc($patientCcdev, $database);
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
            Schema::connection($connectionName)->table('patient_fp', function (Blueprint $table) {
                $table->string('wahtermelon_fp_id')->nullable()->after('id');
                // Add more columns if needed
            });

        } catch (\Exception $e) {
            // Handle the exception (column already exists)
            // You can log the error or perform other actions if needed
            // For now, we'll just skip this iteration
            //continue;
        }
    }

    /**
     * Process Patient Family Planning
     *
     * @param $patientFp
     * @param $facilityCode
     * @return void
     */
    private function processPatientFp($patientFp, $facilityCode): void
    {
        $patientFpBar = $this->output->createProgressBar(count($patientFp));
        $patientFpBar->setFormat('Processing Patient Family Planning Table: %current%/%max% [%bar%] %percent:3s%% Elapsed: %elapsed:6s% Remaining: %remaining:6s% Estimated: %estimated:-6s%');
        $patientFpBar->start();
        $startTime = time();

        $this->chunkAndProcess($patientFp, $facilityCode, $patientFpBar);

        $patientFpBar->finish();
        $this->displayElapsedTime($startTime);
    }

    /**
     * Chunk and Process Patient Cc Data
     *
     * @param $patientFp
     * @param $facilityCode
     * @param $patientFpBar
     * @return void
     */
    private function chunkAndProcess($patientFp, $facilityCode, $patientFpBar): void
    {
        $chunkSize = 200;
        $chunks = array_chunk($patientFp->toArray(), $chunkSize);

        foreach ($chunks as $chunk) {
            foreach ($chunk as $patientFpData) {
                $this->processPatientFpData($patientFpData, $facilityCode);
                $patientFpBar->advance();
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

    private function savePatientFp($patientCc, $facilityCode)
    {
        $patientCcCount = count($patientCc);
        if ($patientCcCount < 1) {
            $this->components->info('Nothing to migrate for Patient Family Planning');
            return;
        }

        $this->processPatientFp($patientCc, $facilityCode);

        $this->newLine();
        $this->components->twoColumnDetail('Patient Family Planning Migration', 'Done');
    }

    private function saveFpMethod($methods, $fpId, $facilityCode)
    {
        foreach ($methods as $method) {
            $method = (array)$method;
            $fpMethod = PatientFpMethod::query()->updateOrCreate(['patient_fp_id' => $fpId, 'enrollment_date' => $method['enrollment_date']], $method + ['facility_code' => $facilityCode]);
            $services = $this->getMethodServices($method['id']);
            $this->saveMethodServices($services, $fpId, $fpMethod->id, $facilityCode);
        }
    }

    private function saveMethodServices($services, $fpId, $methodId, $facilityCode)
    {
        foreach ($services as $service) {
            $service = (array)$service;
            PatientFpChart::query()->updateOrCreate(['patient_fp_id' => $fpId, 'patient_fp_method_id' => $methodId, 'service_date' => $service['service_date']], $service + ['facility_code' => $facilityCode]);
        }
    }

    private function saveFpPelvic($pelvics, $fpId, $facilityCode)
    {
        foreach ($pelvics as $pelvic) {
            $pelvic = (array)$pelvic;
            PatientFpPelvicExam::query()->updateOrCreate(['patient_fp_id' => $fpId, 'pelvic_exam_code' => $pelvic['pelvic_exam_code']], $pelvic + ['facility_code' => $facilityCode]);
        }
    }

    private function saveFpHistory($histories, $fpId, $facilityCode)
    {
        foreach ($histories as $history) {
            $history = (array)$history;
            PatientFpHistory::query()->updateOrCreate(['patient_fp_id' => $fpId, 'history_code' => $history['history_code']], $history + ['facility_code' => $facilityCode]);
        }
    }

    private function saveFpPhysicalExam($physicalExams, $fpId, $facilityCode)
    {
        foreach ($physicalExams as $physicalExam) {
            $physicalExam = (array)$physicalExam;
            PatientFpPhysicalExam::query()->updateOrCreate(['patient_fp_id' => $fpId, 'pe_id' => $physicalExam['pe_id']], $physicalExam + ['facility_code' => $facilityCode]);
        }
    }

    private function processPatientFpData($patientFpData, $facilityCode): void
    {
        DB::transaction(function () use ($patientFpData, $facilityCode) {
            $patientFpData = (array)$patientFpData;
            //dd($patientFpData);
            $patientFpData['facility_code'] = $facilityCode;
            $fp = PatientFp::query()->updateOrCreate(['patient_id' => $patientFpData['patient_id']], $patientFpData);

            $methods = $this->getFpMethods($patientFpData['id']);
            if(count($methods) > 0) {
                $this->saveFpMethod($methods, $fp->id, $facilityCode);
            }

            $pelvics = $this->getPelvic($patientFpData['id']);
            if(count($pelvics) > 0) {
                $this->saveFpPelvic($pelvics, $fp->id, $facilityCode);
            }

            $histories = $this->getHistory($patientFpData['id']);
            if(count($histories) > 0) {
                $this->saveFpHistory($histories, $fp->id, $facilityCode);
            }

            $physicalExams = $this->getPhysicalExam($patientFpData['id']);
            if(count($physicalExams) > 0) {
                $this->saveFpPhysicalExam($physicalExams, $fp->id, $facilityCode);
            }
            DB::connection('mysql_migration')->table('patient_fp')->where('id', $patientFpData['id'])->update(['wahtermelon_fp_id' => $fp->id]);
        });
    }

    public function getPatientFp()
    {
        return DB::connection('mysql_migration')->table('patient_fp')
            ->selectRaw('
                patient_fp.*
            ')
            ->addSelect(
                'patient.wahtermelon_patient_id AS patient_id',
                'user.wahtermelon_user_id AS user_id',
                'ave_monthly_income AS average_monthly_income'
            )
            ->join('patient AS patient', function ($join) {
                $join->on('patient_fp.patient_id', '=', 'patient.id')
                    ->whereNotNull('patient.wahtermelon_patient_id');
            })
            ->join('user AS user', function ($join) {
                $join->on('patient_fp.user_id', '=', 'user.id')
                    ->whereNotNull('user.wahtermelon_user_id');
            })
            ->whereNull('wahtermelon_fp_id')
            ->get();
    }

    public function getFpMethods($fpId)
    {
        return DB::connection('mysql_migration')->table('patient_fp_method')
            ->selectRaw('
                patient_fp_method.*
            ')
            ->addSelect(
                'patient.wahtermelon_patient_id AS patient_id',
                'user.wahtermelon_user_id AS user_id',
                'method_id AS method_code',
                'date_registered AS enrollment_date',
                'date_dropout AS dropout_date',
                DB::raw('
                    CASE
                        WHEN dropout_reason IS NOT NULL AND dropout_reason LIKE "Pregnant%"
                        THEN 1
                        WHEN dropout_reason IS NOT NULL AND dropout_reason LIKE "Desire%"
                        THEN 2
                        WHEN dropout_reason IS NOT NULL AND dropout_reason LIKE "Medical%"
                        THEN 3
                        WHEN dropout_reason IS NOT NULL AND dropout_reason LIKE "Fear%"
                        THEN 4
                        WHEN dropout_reason IS NOT NULL AND dropout_reason LIKE "Changed%"
                        THEN 5
                        WHEN dropout_reason IS NOT NULL AND dropout_reason LIKE "Husband%"
                        THEN 6
                        WHEN dropout_reason IS NOT NULL AND dropout_reason LIKE "Menopause%"
                        THEN 7
                        WHEN dropout_reason IS NOT NULL AND dropout_reason LIKE "Lost%"
                        THEN 8
                        WHEN dropout_reason IS NOT NULL AND dropout_reason LIKE "Failed%"
                        THEN 9
                        WHEN dropout_reason IS NOT NULL AND dropout_reason LIKE "IUD%"
                        THEN 10
                        WHEN dropout_reason IS NOT NULL AND dropout_reason LIKE "Unknown%"
                        THEN 11
                        WHEN dropout_reason IS NOT NULL AND dropout_reason LIKE "Changing%"
                        THEN 12
                        WHEN dropout_reason IS NULL OR dropout_reason = ""
                        THEN NULL
                        WHEN dropout_reason IN ("1","2","3","4","5","6","7","8","9","10","11","12")
                        THEN dropout_reason
                        ELSE 11
                    END AS dropout_reason_code
                ')
            )
            ->join('patient AS patient', function ($join) {
                $join->on('patient_fp_method.patient_id', '=', 'patient.id')
                    ->whereNotNull('patient.wahtermelon_patient_id');
            })
            ->join('user AS user', function ($join) {
                $join->on('patient_fp_method.user_id', '=', 'user.id')
                    ->whereNotNull('user.wahtermelon_user_id');
            })
            //->whereRaw('dropout_reason LIKE "Lost%"')
            ->whereNotNull('date_registered')
            ->whereNotNull('client_code')
            ->where('client_code', '!=', '')
            ->whereNotNull('treatment_partner')
            ->whereDate('date_registered', '>=', '0001-01-01')
            ->whereDate('date_registered', '<=', '9999-12-31')
            ->whereFpId($fpId)
            ->get();
    }

    public function getMethodServices($methodId)
    {
        return DB::connection('mysql_migration')->table('patient_fp_method_service')
            ->selectRaw('
                patient_fp_method_service.*
            ')
            ->addSelect(
                'patient.wahtermelon_patient_id AS patient_id',
                'user.wahtermelon_user_id AS user_id',
                'date_service AS service_date',
                'source_id AS source_supply_code'
            )
            ->join('patient AS patient', function ($join) {
                $join->on('patient_fp_method_service.patient_id', '=', 'patient.id')
                    ->whereNotNull('patient.wahtermelon_patient_id');
            })
            ->join('user AS user', function ($join) {
                $join->on('patient_fp_method_service.user_id', '=', 'user.id')
                    ->whereNotNull('user.wahtermelon_user_id');
            })
            ->where('fp_px_id', $methodId)
            ->whereNotNull('date_service')
            ->where('source_id', '!=', 0)
            ->whereDate('next_service_date', '>=', '0001-01-01')
            ->whereDate('next_service_date', '<=', '9999-12-31')
            //->whereNull('wahtermelon_fp_id')
            ->get();
    }

    public function getPelvic($fpId)
    {
        return DB::connection('mysql_migration')->table('patient_fp_pelvic')
            ->selectRaw('
                patient_fp_pelvic.*
            ')
            ->addSelect(
                'patient.wahtermelon_patient_id AS patient_id',
                'user.wahtermelon_user_id AS user_id',
                'pelvic_id AS pelvic_exam_code'
            )
            ->join('patient AS patient', function ($join) {
                $join->on('patient_fp_pelvic.patient_id', '=', 'patient.id')
                    ->whereNotNull('patient.wahtermelon_patient_id');
            })
            ->join('user AS user', function ($join) {
                $join->on('patient_fp_pelvic.user_id', '=', 'user.id')
                    ->whereNotNull('user.wahtermelon_user_id');
            })
            ->where('fp_id', $fpId)
            ->get();
    }

    public function getHistory($fpId)
    {
        return DB::connection('mysql_migration')->table('patient_fp_hx')
            ->selectRaw('
                patient_fp_hx.*
            ')
            ->addSelect(
                'patient.wahtermelon_patient_id AS patient_id',
                'user.wahtermelon_user_id AS user_id',
                'history_id AS history_code'
            )
            ->join('patient AS patient', function ($join) {
                $join->on('patient_fp_hx.patient_id', '=', 'patient.id')
                    ->whereNotNull('patient.wahtermelon_patient_id');
            })
            ->join('user AS user', function ($join) {
                $join->on('patient_fp_hx.user_id', '=', 'user.id')
                    ->whereNotNull('user.wahtermelon_user_id');
            })
            ->where('fp_id', $fpId)
            ->get();
    }

    public function getPhysicalExam($fpId)
    {
        return DB::connection('mysql_migration')->table('patient_fp_pe')
            ->selectRaw('
                patient_fp_pe.*
            ')
            ->addSelect(
                'patient.wahtermelon_patient_id AS patient_id',
                'user.wahtermelon_user_id AS user_id',
                DB::raw('
                    CASE
                        WHEN pe_id = "1" THEN "CONJUNCTIVA01"
                        WHEN pe_id = "2" THEN "CONJUNCTIVA02"
                        WHEN pe_id = "3" THEN "NECK01"
                        WHEN pe_id = "4" THEN "NECK02"
                        WHEN pe_id = "5" THEN "BREAST05"
                        WHEN pe_id = "6" THEN "BREAST06"
                        WHEN pe_id = "7" THEN "BREAST07"
                        WHEN pe_id = "8" THEN "BREAST08"
                        WHEN pe_id = "9" THEN "THORAX01"
                        WHEN pe_id = "10" THEN "THORAX02"
                        WHEN pe_id = "11" THEN "ABDOMEN10"
                        WHEN pe_id = "12" THEN "ABDOMEN09"
                        WHEN pe_id = "13" THEN "ABDOMEN05"
                        WHEN pe_id = "14" THEN "EXTREMITIES04"
                        WHEN pe_id = "15" THEN "EXTREMITIES05"
                        ELSE NULL
                    END AS pe_id
                ')
            )
            ->join('patient AS patient', function ($join) {
                $join->on('patient_fp_pe.patient_id', '=', 'patient.id')
                    ->whereNotNull('patient.wahtermelon_patient_id');
            })
            ->join('user AS user', function ($join) {
                $join->on('patient_fp_pe.user_id', '=', 'user.id')
                    ->whereNotNull('user.wahtermelon_user_id');
            })
            ->whereIn('pe_id', [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15])
            ->where('fp_id', $fpId)
            ->get();
    }
}
