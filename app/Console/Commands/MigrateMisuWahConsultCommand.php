<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Consultation\ConsultNotes;
use App\Models\V1\Consultation\ConsultNotesComplaint;
use App\Models\V1\Consultation\ConsultNotesFinalDx;
use App\Models\V1\Consultation\ConsultNotesInitialDx;
use App\Models\V1\Patient\Patient;
use Illuminate\Console\Command;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrateMisuWahConsultCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'misuwah:migrate-consult';

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
        $consults = $this->getConsult();
        //echo $consults;
        //echo Consult::get();
        $this->saveConsult($consults, $database, $connectionName);
    }

    private function getConsult()
    {
//        $duplicateNotes = DB::connection('mysql_migration')->table('consult_notes as duplicate_notes')
//            ->whereColumn('duplicate_notes.id', 'consult_notes.id')
//            ->groupBy('duplicate_notes.consult_id')
//            ->havingRaw('COUNT(duplicate_notes.consult_id)>1');
        $consultNotes = DB::connection('mysql_migration')->table('consult_notes')
            ->selectRaw('1')
            ->whereColumn('consult_notes.consult_id', 'consult.id')
            ->whereColumn('consult_notes.patient_id', 'consult.patient_id');;

        return DB::connection('mysql_migration')->table('consult')
            ->selectRaw('
                consult.id AS id,
                wahtermelon_patient_id AS patient_id,
                user.wahtermelon_user_id AS user_id,
                physician.wahtermelon_user_id AS physician_id,
                CASE
                    WHEN is_pregnant = "Y"
                    THEN 1
                    WHEN is_pregnant = "N"
                    THEN 0
                    ELSE NULL
                END is_pregnant,
                CASE
                    WHEN consult_done = "Y"
                    THEN 1
                    ELSE NULL
                END consult_done,
                consult.ptgroup AS pt_group,
                consult.created_at AS consult_date,
                consult.created_at,
                consult.updated_at
            ')
//            ->join('consult_notes', function ($join) {
//                $join->on('consult.id', '=', 'consult_notes.consult_id')
//                    ->select('id', 'consult_id');
//            })
            ->join('user AS user', function ($join) {
                $join->on('consult.user_id', '=', 'user.id')
                    ->whereNotNull('user.wahtermelon_user_id');
            })
            ->leftJoin('user AS physician', function ($join) {
                $join->on('consult.physician_id', '=', 'physician.id')
                    ->whereNotNull('physician.wahtermelon_user_id');
            })
            ->join('patient', function ($join) {
                $join->on('consult.patient_id', '=', 'patient.id')
                    ->whereNotNull('patient.wahtermelon_patient_id');
            })
            ->whereExists($consultNotes)
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('consult_notes as duplicate_notes')
                    ->whereColumn('duplicate_notes.consult_id', 'consult.id')
                    ->groupBy('duplicate_notes.consult_id')
                    ->havingRaw('COUNT(duplicate_notes.consult_id)>1');
            })
            ->wherePtgroup('cn')
            //->whereNull('consult.wahtermelon_consult_id')
            ->whereNotNull('consult.consult_end')
            ->whereDate('consult_end', '>=', '0001-01-01')
            ->whereDate('consult_end', '<=', '9999-12-31')
            ->whereDate('consult_end', '<=', now())
            ->whereDate('consult.created_at', '>=', '0001-01-01')
            ->whereDate('consult.created_at', '<=', '9999-12-31')
            ->whereDate('consult.created_at', '<=', now())
            ->get();
    }

    private function getConsultNotes($consultId)
    {
        return DB::connection('mysql_migration')->table('consult_notes')
            ->selectRaw('
                consult_notes.id AS id,
                wahtermelon_patient_id AS patient_id,
                user.wahtermelon_user_id AS user_id,
                complaint,
                history,
                physical_exam,
                plan,
                consult_notes.created_at,
                consult_notes.updated_at
            ')
            ->leftJoin('user AS user', function ($join) {
                $join->on('consult_notes.user_id', '=', 'user.id')
                    ->whereNotNull('user.wahtermelon_user_id');
            })
            ->join('patient', function ($join) {
                $join->on('consult_notes.patient_id', '=', 'patient.id')
                    ->whereNotNull('patient.wahtermelon_patient_id');
            })
            ->whereDate('consult_notes.created_at', '>=', '0001-01-01')
            ->whereDate('consult_notes.created_at', '<=', '9999-12-31')
            ->whereDate('consult_notes.created_at', '<=', now())
            ->whereDate('consult_notes.updated_at', '>=', '0001-01-01')
            ->whereDate('consult_notes.updated_at', '<=', '9999-12-31')
            ->whereDate('consult_notes.updated_at', '<=', now())
            ->whereConsultId($consultId)
            ->first();
    }

    private function getNotesComplaints($notesId, $consultId, $patientId)
    {
        return DB::connection('mysql_migration')->table('consult_notes_complaint')
            ->selectRaw('
                complaint_id,
                consult_notes_complaint.created_at,
                consult_notes_complaint.updated_at
            ')
            ->join('patient', function ($join) {
                $join->on('consult_notes_complaint.patient_id', '=', 'patient.id')
                    ->whereNotNull('patient.wahtermelon_patient_id');
            })
            ->whereNotesId($notesId)
            ->whereConsultId($consultId)
            ->where('patient.wahtermelon_patient_id', $patientId)
            ->whereDate('consult_notes_complaint.created_at', '>=', '0001-01-01')
            ->whereDate('consult_notes_complaint.created_at', '<=', '9999-12-31')
            ->whereDate('consult_notes_complaint.created_at', '<=', now())
            ->whereDate('consult_notes_complaint.updated_at', '>=', '0001-01-01')
            ->whereDate('consult_notes_complaint.updated_at', '<=', '9999-12-31')
            ->whereDate('consult_notes_complaint.updated_at', '<=', now())
            ->get();
    }

    private  function getNotesInitialDiagnosis($notesId)
    {
        return DB::connection('mysql_migration')->table('consult_notes_initial_dx')
            ->selectRaw('
                consult_notes_initial_dx.class_id,
                user.wahtermelon_user_id AS user_id,
                consult_notes_initial_dx.created_at,
                consult_notes_initial_dx.updated_at
            ')
            ->leftJoin('user', function ($join) {
                $join->on('consult_notes_initial_dx.user_id', '=', 'user.id')
                    ->whereNotNull('user.wahtermelon_user_id');
            })
            ->join('lib_diagnosis', 'lib_diagnosis.class_id', '=', 'consult_notes_initial_dx.class_id')
            ->whereNotesId($notesId)
            ->whereDate('consult_notes_initial_dx.created_at', '>=', '0001-01-01')
            ->whereDate('consult_notes_initial_dx.created_at', '<=', '9999-12-31')
            ->whereDate('consult_notes_initial_dx.created_at', '<=', now())
            ->whereDate('consult_notes_initial_dx.updated_at', '>=', '0001-01-01')
            ->whereDate('consult_notes_initial_dx.updated_at', '<=', '9999-12-31')
            ->whereDate('consult_notes_initial_dx.updated_at', '<=', now())
            ->get();
    }

    private  function getNotesFinalDiagnosis($notesId)
    {
        return DB::connection('mysql_migration')->table('consult_notes_final_dx')
            ->selectRaw('
                consult_notes_final_dx.icd10_code,
                user.wahtermelon_user_id AS user_id,
                consult_notes_final_dx.created_at,
                consult_notes_final_dx.updated_at
            ')
            ->leftJoin('user', function ($join) {
                $join->on('consult_notes_final_dx.user_id', '=', 'user.id')
                    ->whereNotNull('user.wahtermelon_user_id');
            })
            //->join('lib_diagnosis', 'lib_diagnosis.class_id', '=', 'consult_notes_initial_dx.class_id')
            ->whereNotesId($notesId)
            ->whereNotNull('icd10_code')
            ->where('icd10_code', '!=', '')
            ->whereDate('consult_notes_final_dx.created_at', '>=', '0001-01-01')
            ->whereDate('consult_notes_final_dx.created_at', '<=', '9999-12-31')
            ->whereDate('consult_notes_final_dx.created_at', '<=', now())
            ->whereDate('consult_notes_final_dx.updated_at', '>=', '0001-01-01')
            ->whereDate('consult_notes_final_dx.updated_at', '<=', '9999-12-31')
            ->whereDate('consult_notes_final_dx.updated_at', '<=', now())
            ->get();
    }

    private  function saveConsult($consults, $database, $connectionName)
    {
        /*$consultBar = $this->output->createProgressBar(count($consults));
        $consultBar->setFormat('Processing User Table: %current%/%max% [%bar%] %percent:3s%%');
        $consultBar->start();
        foreach($consults as $consult) {
            $consult = (array) $consult;
            //dd($consult);
            //var_dump($consult);
            $newConsult = Consult::query()->updateOrCreate(['patient_id' => $consult['patient_id'], 'consult_date' => $consult['consult_date'], 'pt_group' => $consult['pt_group']], $consult + ['facility_code' => $database]);
            DB::connection($connectionName)->table('consult')->whereId($consult['id'])->update(['wahtermelon_consult_id' => $newConsult->id]);
            $consultBar->advance();
        }
        $consultBar->finish();
        $this->newLine();
        $this->components->twoColumnDetail('Consult Migration', 'Done');
        $this->newLine();*/
        $consultsCount = count($consults);
        if($consultsCount < 1){
            $this->components->info('Nothing to migrate');
            return;
        }
        $consultBar = $this->output->createProgressBar($consultsCount);
        $consultBar->setFormat('Processing User Table: %current%/%max% [%bar%] %percent:3s%% Elapsed: %elapsed:6s% Remaining: %estimated:-6s%');
        $consultBar->start();
        $startTime = time();

        $chunkSize = 200; // Set your desired chunk size

        $chunks = array_chunk($consults->toArray(), $chunkSize);
        foreach ($chunks as $chunk) {
            foreach ($chunk as $consult) {
                $consult = (array)$consult;
                // Your existing code for processing $consult
                DB::transaction(function () use ($consult, $database, $connectionName) {
                    $newConsult = Consult::query()->updateOrCreate([
                        'patient_id' => $consult['patient_id'],
                        'consult_date' => $consult['consult_date'],
                        'pt_group' => $consult['pt_group']
                    ], $consult + ['facility_code' => $database]);

                    DB::connection($connectionName)->table('consult')->whereId($consult['id'])->update(['wahtermelon_consult_id' => $newConsult->id]);
                    $consultNotes = (array)$this->getConsultNotes($consult['id']);
//                echo $consult['id'];
//                print_r($consultNotes);
                    $consultNotes['user_id'] = $consultNotes['user_id'] ?? $consult['user_id'];
                    $newConsultNotes = ConsultNotes::query()->updateOrCreate(['consult_id' => $newConsult->id], $consultNotes + ['facility_code' => $database]);

                    //Save Notes Complaints;
                    $complaints = $this->getNotesComplaints($consultNotes['id'], $consult['id'], $consult['patient_id']);
                    if (!empty($complaints)) {
                        foreach ($complaints as $complaint) {
                            $complaint = (array)$complaint;
                            ConsultNotesComplaint::query()->updateOrCreate(['notes_id' => $newConsultNotes->id, 'consult_id' => $newConsult->id, 'patient_id' => $consult['patient_id'], 'complaint_id' => $complaint['complaint_id']], $complaint + ['user_id' => $consultNotes['user_id'], 'facility_code' => $database]);
                        }
                    }

                    //Save Initial Diagnoses
                    $initialDiagnoses = $this->getNotesInitialDiagnosis($consultNotes['id']);
                    if (!empty($initialDiagnoses)) {
                        foreach ($initialDiagnoses as $initialDiagnosis) {
                            $initialDiagnosis = (array)$initialDiagnosis;
                            $initialDiagnosis['user_id'] = $initialDiagnosis['user_id'] ?? $consult['user_id'];
                            ConsultNotesInitialDx::query()->updateOrCreate(['notes_id' => $newConsultNotes->id, 'class_id' => $initialDiagnosis['class_id']], $initialDiagnosis + ['facility_code' => $database]);
                        }
                    }

                    //Save Final Diagnoses
                    $finalDiagnoses = $this->getNotesFinalDiagnosis($consultNotes['id']);
                    if (!empty($finalDiagnoses)) {
                        foreach ($finalDiagnoses as $finalDiagnosis) {
                            $finalDiagnosis = (array)$finalDiagnosis;
                            $finalDiagnosis['user_id'] = $finalDiagnosis['user_id'] ?? $consult['user_id'];
                            ConsultNotesFinalDx::query()->updateOrCreate(['notes_id' => $newConsultNotes->id, 'icd10_code' => $finalDiagnosis['icd10_code']], $finalDiagnosis + ['facility_code' => $database]);
                        }
                    }
                });

                $consultBar->advance();
            }
        }

        $consultBar->finish();
        $endTime = time();
        $elapsedTime = $endTime - $startTime;

        $this->newLine();
        $this->components->twoColumnDetail('Consult Migration', 'Done');
        $this->newLine();
        $this->line('Elapsed Time: ' . gmdate('H:i:s', $elapsedTime));

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
            Schema::connection($connectionName)->table('consult', function (Blueprint $table) {
                $table->string('wahtermelon_consult_id')->nullable()->after('id');
                // Add more columns if needed
            });
        } catch (\Exception $e) {
            // Handle the exception (column already exists)
            // You can log the error or perform other actions if needed
            // For now, we'll just skip this iteration
            //continue;
        }
    }
}
