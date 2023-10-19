<?php

namespace App\Console\Commands;

use App\Models\V1\Patient\PatientHistory;
use App\Models\V1\Patient\PatientVitals;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrateMisuWahHistoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'misuwah:migrate-history';

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

        $vitals = $this->getVitals();
        $this->saveVitals($vitals, $database);

        $medicalHistory = $this->getMedicalHistory();
        $this->saveMedicalHistory($medicalHistory, $database);
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
            Schema::connection($connectionName)->table('consult_vitals', function (Blueprint $table) {
                $table->string('wahtermelon_vitals_id')->nullable()->after('vitals_id');
                // Add more columns if needed
            });

        } catch (\Exception $e) {
            // Handle the exception (column already exists)
            // You can log the error or perform other actions if needed
            // For now, we'll just skip this iteration
            //continue;
        }

        try {
            // Add column if it doesn't exist on the 'patient' table
            Schema::connection($connectionName)->table('patient_history', function (Blueprint $table) {
                $table->boolean('migrated')->nullable()->after('id')->default(0);
                // Add more columns if needed
            });

        } catch (\Exception $e) {
            // Handle the exception (column already exists)
            // You can log the error or perform other actions if needed
            // For now, we'll just skip this iteration
            //continue;
        }
    }

    public function getVitals()
    {
        return DB::connection('mysql_migration')->table('consult_vitals')
            ->selectRaw('
                vitals_id AS id,
                consult.wahtermelon_consult_id AS consult_id,
                patient.wahtermelon_patient_id AS patient_id,
                user.wahtermelon_user_id AS user_id,
                patient.birthdate AS birthdate,
                vitals_date,
                CASE
                    WHEN vitals_weight = 0
                    THEN NULL
                    ELSE vitals_weight
                END AS patient_weight,
                CASE
                    WHEN vitals_height = 0
                    THEN NULL
                    ELSE vitals_height
                END AS patient_height,
                CASE
                    WHEN vitals_temp = 0
                    THEN NULL
                    ELSE vitals_temp
                END AS patient_temp,
                CASE
                    WHEN vitals_systolic = 0
                    THEN NULL
                    ELSE vitals_systolic
                END AS bp_systolic,
                CASE
                    WHEN vitals_diastolic = 0
                    THEN NULL
                    ELSE vitals_diastolic
                END AS bp_diastolic,
                CASE
                    WHEN vitals_heartrate = 0
                    THEN NULL
                    ELSE vitals_heartrate
                END AS patient_heart_rate,
                CASE
                    WHEN vitals_resprate = 0
                    THEN NULL
                    ELSE vitals_resprate
                END AS patient_respiratory_rate,
                CASE
                    WHEN vitals_pulse = 0
                    THEN NULL
                    ELSE vitals_pulse
                END AS patient_pulse_rate,
                CASE
                    WHEN vitals_waist = 0
                    THEN NULL
                    ELSE vitals_waist
                END AS patient_waist,
                CASE
                    WHEN vitals_muac = 0
                    THEN NULL
                    ELSE vitals_muac
                END AS patient_muac,
                vitals_muac AS patient_muac
            ')
            ->join('patient', function ($join) {
                $join->on('consult_vitals.patient_id', '=', 'patient.id')
                    ->whereNotNull('patient.wahtermelon_patient_id');
            })
            ->join('user AS user', function ($join) {
                $join->on('consult_vitals.user_id', '=', 'user.id')
                    ->whereNotNull('user.wahtermelon_user_id');
            })
            ->leftJoin('consult', function ($join) {
                $join->on('consult_vitals.consult_id', '=', 'consult.id')
                    ->whereNotNull('consult.wahtermelon_consult_id');
            })
            ->whereNull('wahtermelon_vitals_id')
            ->get();
    }

    public function saveVitals($vitals, $facilityCode)
    {
        $vitalsCount = count($vitals);
        if ($vitalsCount < 1) {
            $this->components->info('Nothing to migrate');
            return;
        }
        //Delete duplicate dispensing records

        $vitalsBar = $this->output->createProgressBar($vitalsCount);
        $vitalsBar->setFormat('Processing Patient Vitals Table: %current%/%max% [%bar%] %percent:3s%% Elapsed: %elapsed:6s% Remaining: %remaining:6s% Estimated: %estimated:-6s%');
        $vitalsBar->start();
        $startTime = time();

        $chunkSize = 200; // Set your desired chunk size
        $chunks = array_chunk($vitals->toArray(), $chunkSize);

        foreach ($chunks as $chunk) {
            foreach ($chunk as $vitalsData) {
                $years = Carbon::parse($vitalsData->birthdate)->diffInYears($vitalsData->vitals_date);
                $months = Carbon::parse($vitalsData->birthdate)->diffInMonths($vitalsData->vitals_date);
                $vitalsData = (array) $vitalsData;
                $vitalsData['patient_age_years'] = $years;
                $vitalsData['patient_age_months'] = $months;
                unset($vitalsData['birthdate']);
                //dd($vitalsData);
                DB::transaction(function () use ($vitalsData, $facilityCode) {
                    $vitals = PatientVitals::query()
                        ->updateOrCreate(['patient_id' => $vitalsData['patient_id'], 'vitals_date' => $vitalsData['vitals_date']], $vitalsData + ['facility_code' => $facilityCode]);
                    DB::connection('mysql_migration')->table('consult_vitals')->where('vitals_id', $vitalsData['id'])->update(['wahtermelon_vitals_id' => $vitals->id]);

                });

                $vitalsBar->advance();
            }
        }
        $vitalsBar->finish();
        $endTime = time();
        $elapsedTime = $endTime - $startTime;

        $this->newLine();
        $this->components->twoColumnDetail('Patient Vitals Migration', 'Done');
        $this->newLine();
        $this->line('Elapsed Time: ' . gmdate('H:i:s', $elapsedTime));
    }

    public function getMedicalHistory()
    {
        return DB::connection('mysql_migration')->table('patient_history')
            ->selectRaw('
                patient_history.id AS id,
                patient.wahtermelon_patient_id AS patient_id,
                user.wahtermelon_user_id AS user_id,
                pasthistory_id,
                familyhistory_id,
                smoking,
                pack_peryear AS pack_per_year,
                alcohol,
                bottles_perday AS bottles_per_day,
                ill_drugs AS illicit_drugs,
                patient_history.created_at,
                patient_history.updated_at
            ')
            ->join('patient', function ($join) {
                $join->on('patient_history.patient_id', '=', 'patient.id')
                    ->whereNotNull('patient.wahtermelon_patient_id');
            })
            ->join('user AS user', function ($join) {
                $join->on('patient_history.user_id', '=', 'user.id')
                    ->whereNotNull('user.wahtermelon_user_id');
            })
            ->get();
    }

    public function saveMedicalHistory($medicalHistory, $facilityCode)
    {
        $medicalHistoryCount = count($medicalHistory);
        if ($medicalHistoryCount < 1) {
            $this->components->info('Nothing to migrate');
            return;
        }
        //Delete duplicate dispensing records

        $medicalHistoryBar = $this->output->createProgressBar($medicalHistoryCount);
        $medicalHistoryBar->setFormat('Processing Patient History Table: %current%/%max% [%bar%] %percent:3s%% Elapsed: %elapsed:6s% Remaining: %remaining:6s% Estimated: %estimated:-6s%');
        $medicalHistoryBar->start();
        $startTime = time();

        $chunkSize = 200; // Set your desired chunk size
        $chunks = array_chunk($medicalHistory->toArray(), $chunkSize);

        foreach ($chunks as $chunk) {
            foreach ($chunk as $medicalHistoryData) {

                DB::transaction(function () use ($medicalHistoryData, $facilityCode) {
                    $data = [
                        'facility_code' => $facilityCode,
                        'patient_id' => $medicalHistoryData->patient_id,
                        'user_id' => $medicalHistoryData->user_id,
                        'created_at' => $medicalHistoryData->created_at,
                        'updated_at' => $medicalHistoryData->updated_at
                    ];

                    if($medicalHistoryData->pasthistory_id){
                        $pastMedical = explode(',', $medicalHistoryData->pasthistory_id);
                        foreach($pastMedical as $value){
                            PatientHistory::query()
                                ->updateOrCreate(['patient_id' => $medicalHistoryData->patient_id], $data + ['medical_history_id' => $value, 'category' => 1]);
                        }
                    }
                    if($medicalHistoryData->familyhistory_id){
                        $familyHistory = explode(',', $medicalHistoryData->familyhistory_id);
                        foreach($familyHistory as $value){
                            PatientHistory::query()
                                ->updateOrCreate(['patient_id' => $medicalHistoryData->patient_id], $data + ['medical_history_id' => $value, 'category' => 2]);
                        }
                    }
                    //DB::connection('mysql_migration')->table('consult_vitals')->where('vitals_id', $vitalsData['id'])->update(['wahtermelon_vitals_id' => $vitals->id]);

                });

                $medicalHistoryBar->advance();
            }
        }
        $medicalHistoryBar->finish();
        $endTime = time();
        $elapsedTime = $endTime - $startTime;

        $this->newLine();
        $this->components->twoColumnDetail('Patient History Migration', 'Done');
        $this->newLine();
        $this->line('Elapsed Time: ' . gmdate('H:i:s', $elapsedTime));
    }
}
