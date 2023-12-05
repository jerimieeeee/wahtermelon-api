<?php

namespace App\Console\Commands;

use App\Models\V1\MaternalCare\PatientMc;
use App\Models\V1\MaternalCare\PatientMcPreRegistration;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrateMisuWahMaternalCareCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'misuwah:migrate-mc';

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

        $patientMc = $this->getPatientMc();
        $this->savePatientMc($patientMc, $database);
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
            Schema::connection($connectionName)->table('patient_mc', function (Blueprint $table) {
                $table->string('wahtermelon_mc_id')->nullable()->after('mc_id');
                // Add more columns if needed
            });

        } catch (\Exception $e) {
            // Handle the exception (column already exists)
            // You can log the error or perform other actions if needed
            // For now, we'll just skip this iteration
            //continue;
        }
    }

    public function getPatientMc()
    {
        return DB::connection('mysql_migration')->table('patient_mc')
            ->selectRaw('
                patient_mc.*
            ')
            ->addSelect(
                'patient.wahtermelon_patient_id AS patient_id',
                'user.wahtermelon_user_id AS user_id',
                DB::raw('
                    CASE WHEN healthy_baby = "Y" THEN 1 ELSE 0 END AS healthy_baby,
                    CASE WHEN breastfeeding = "Y" THEN 1 ELSE 0 END AS breastfeeding,
                    CASE WHEN end_pregnancy = "Y" THEN 1 ELSE 0 END AS end_pregnancy,
                    CASE WHEN delivery_location IS NOT NULL THEN delivery_location ELSE "HC" END AS delivery_location_code
                '))
            ->join('patient', function ($join) {
                $join->on('patient_mc.patient_id', '=', 'patient.id')
                    ->whereNotNull('patient.wahtermelon_patient_id');
            })
            ->join('user AS user', function ($join) {
                $join->on('patient_mc.user_id', '=', 'user.id')
                    ->whereNotNull('user.wahtermelon_user_id');
            })
            //->whereNull('wahtermelon_mc_id')
            ->whereNull('deleted_at')
            ->get();
    }

    public function savePatientMc($patientMc, $facilityCode)
    {
        $patientMcCount = count($patientMc);
        if ($patientMcCount < 1) {
            $this->components->info('Nothing to migrate');
            return;
        }
        //Delete duplicate dispensing records

        $patientMcBar = $this->output->createProgressBar($patientMcCount);
        $patientMcBar->setFormat('Processing Patient Maternal Care Table: %current%/%max% [%bar%] %percent:3s%% Elapsed: %elapsed:6s% Remaining: %remaining:6s% Estimated: %estimated:-6s%');
        $patientMcBar->start();
        $startTime = time();

        $chunkSize = 200; // Set your desired chunk size
        $chunks = array_chunk($patientMc->toArray(), $chunkSize);

        foreach ($chunks as $chunk) {
            foreach ($chunk as $patientMcData) {

                DB::transaction(function () use ($patientMcData, $facilityCode) {
                    $patientMcData = (array) $patientMcData;
                    if (empty($patientMcData['pregnancy_termination_code'])) {
                        unset($patientMcData['pregnancy_termination_code']);
                    }

                    if(!empty($patientMcData['pre_registration_date'])) {

                        $patientMcData['edc_date'] = Carbon::parse($patientMcData['edc_date'])->addDays(280)->format('Y-m-d');
                        $mapping = [
                            'brgy_code' => 'barangay_code',
                            'outcome_id' => 'outcome_code',
                            'attendant_id' => 'attendant_code',
                            // Add more mappings as needed
                        ];

                        foreach ($mapping as $oldKey => $newKey) {
                            if (isset($patientMcData[$oldKey])) {
                                $patientMcData[$newKey] = $patientMcData[$oldKey];
                                unset($patientMcData[$oldKey]);
                            }
                        }

                        $keysToRemove = [
                            'mc_id',
                            'wahtermelon_mc_id',
                            'patient_id',
                            'post_registration_date',
                            'admission_date',
                            'discharge_date',
                            'delivery_date',
                            'delivery_location',
                            'delivery_location_code',
                            'barangay_code',
                            'gravidity',
                            'parity',
                            'full_term',
                            'preterm',
                            'abortion',
                            'livebirths',
                            'outcome_code',
                            'healthy_baby',
                            'birth_weight',
                            'attendant_code',
                            'breastfeeding',
                            'breastfed_date',
                            'end_pregnancy',
                            'postpartum_remarks',
                            'patient_age',
                            'patient_height',
                            'pregnancy_termination_date',
                            'pregnancy_termination_cause',
                            'pregnancy_termination_code'
                        ];

                        $patientMcDataWithoutMcId = collect($patientMcData)
                            ->except($keysToRemove)
                            ->toArray();

                        $mc = PatientMc::query()
                            ->where('patient_id', $patientMcData['patient_id'])
                            ->where('pregnancy_termination_date', $patientMcData['pregnancy_termination_date'])
                            ->where('created_at', $patientMcData['created_at'])
                            ->whereHas('preRegister', function($query) use($patientMcData){
                                $query->where('pre_registration_date', $patientMcData['pre_registration_date'])
                                    ->where('lmp_date', $patientMcData['lmp_date']);
                            })->first();
                        if($mc) {
                            $mc->preRegister()->updateOrCreate($patientMcDataWithoutMcId, $patientMcDataWithoutMcId + ['facility_code' => $facilityCode]);
                        } else {
                            $mc = PatientMc::query()->updateOrCreate(['patient_id' => $patientMcData['patient_id'], 'patient_age' => $patientMcData['patient_age'], 'created_at' => $patientMcData['created_at']], $patientMcData + ['facility_code' => $facilityCode]);
                            $mc->preRegister()->updateOrCreate($patientMcDataWithoutMcId, $patientMcDataWithoutMcId + ['facility_code' => $facilityCode]);
                        }

                        if(!empty($patientMcData['post_registration_date']) && !empty($patientMcData['admission_date'])) {
                            $mc->postRegister()->updateOrCreate(['patient_mc_id' => $mc->id], $patientMcData + ['facility_code' => $facilityCode]);
                        }
                    }

//                    $surgical = PatientSurgicalHistory::query()->updateOrCreate(['patient_id' => $surgicalHistoryData['patient_id']], $surgicalHistoryData + ['facility_code' => $facilityCode]);
                    if ($mc) {
                        DB::connection('mysql_migration')->table('patient_mc')->where('mc_id', $patientMcData['mc_id'])->update(['wahtermelon_mc_id' => $mc->id]);
                    }
                });
            }
        }

        $patientMcBar->finish();
        $endTime = time();
        $elapsedTime = $endTime - $startTime;

        $this->newLine();
        $this->components->twoColumnDetail('Patient Maternal Care Migration', 'Done');
        $this->newLine();
        $this->line('Elapsed Time: ' . gmdate('H:i:s', $elapsedTime));
    }
}
