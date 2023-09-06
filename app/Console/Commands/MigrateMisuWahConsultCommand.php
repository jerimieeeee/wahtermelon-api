<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Consultation\ConsultNotes;
use App\Models\V1\Consultation\ConsultNotesComplaint;
use App\Models\V1\Consultation\ConsultNotesFinalDx;
use App\Models\V1\Consultation\ConsultNotesInitialDx;
use App\Models\V1\Consultation\ConsultNotesPe;
use App\Models\V1\Consultation\ConsultPeRemarks;
use App\Models\V1\Medicine\MedicineDispensing;
use App\Models\V1\Medicine\MedicinePrescription;
use App\Models\V1\Patient\Patient;
use Illuminate\Console\Command;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
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

        $prescriptions =  $this->getMedicinePrescription();
        $this->savePrescription($prescriptions, $database, $connectionName);

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
            ->whereNull('consult.wahtermelon_consult_id')
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

    private function getNotesPe($notesId){
        return DB::connection('mysql_migration')->table('consult_notes_pe')
            ->selectRaw('
                consult_notes_pe.*,
                user.wahtermelon_user_id AS user_id
            ')
            ->leftJoin('user', function ($join) {
                $join->on('consult_notes_pe.user_id', '=', 'user.id')
                    ->whereNotNull('user.wahtermelon_user_id');
            })
            ->where(function ($query) {
                $query->where('breast_remarks', '!=', '')
                    ->orWhere('skin_code', '!=', '')
                    ->orWhere('skin_remarks', '!=', '')
                    ->orWhere('heent_code', '!=', '')
                    ->orWhere('heent_remarks', '!=', '')
                    ->orWhere('chest_code', '!=', '')
                    ->orWhere('chest_remarks', '!=', '')
                    ->orWhere('heart_code', '!=', '')
                    ->orWhere('heart_remarks', '!=', '')
                    ->orWhere('abdomen_code', '!=', '')
                    ->orWhere('abdomen_remarks', '!=', '')
                    ->orWhere('extremities_code', '!=', '')
                    ->orWhere('extremities_remarks', '!=', '');
            })
            ->whereNotesId($notesId)
            ->first();
    }

    private function getInitialDiagnosisRemarks($notesId)
    {
        return DB::connection('mysql_migration')->table('consult_notes_initial_dx')
            ->selectRaw('
                consult_notes_initial_dx.dx_remarks as idx_remarks
            ')
            ->join('lib_diagnosis', 'lib_diagnosis.class_id', '=', 'consult_notes_initial_dx.class_id')
            ->whereNotesId($notesId)
            ->whereDate('consult_notes_initial_dx.created_at', '>=', '0001-01-01')
            ->whereDate('consult_notes_initial_dx.created_at', '<=', '9999-12-31')
            ->whereDate('consult_notes_initial_dx.created_at', '<=', now())
            ->whereDate('consult_notes_initial_dx.updated_at', '>=', '0001-01-01')
            ->whereDate('consult_notes_initial_dx.updated_at', '<=', '9999-12-31')
            ->whereDate('consult_notes_initial_dx.updated_at', '<=', now())
            ->groupBy('notes_id')
            ->first();
    }

    private function getFinalDiagnosisRemarks($notesId)
    {
        return DB::connection('mysql_migration')->table('consult_notes_final_dx')
            ->selectRaw('
                consult_notes_final_dx.dx_remarks as fdx_remarks
            ')
            ->whereNotesId($notesId)
            ->whereDate('consult_notes_final_dx.created_at', '>=', '0001-01-01')
            ->whereDate('consult_notes_final_dx.created_at', '<=', '9999-12-31')
            ->whereDate('consult_notes_final_dx.created_at', '<=', now())
            ->whereDate('consult_notes_final_dx.updated_at', '>=', '0001-01-01')
            ->whereDate('consult_notes_final_dx.updated_at', '<=', '9999-12-31')
            ->whereDate('consult_notes_final_dx.updated_at', '<=', now())
            ->groupBy('notes_id')
            ->first();
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
        $consultBar->setFormat('Processing Consult Table: %current%/%max% [%bar%] %percent:3s%% Elapsed: %elapsed:6s% Remaining: %remaining:-6s% Estimated: %estimated:-6s%');
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
                        $initialDiagnosisRemarks = (array)$this->getInitialDiagnosisRemarks($consultNotes['id']);
                        if(!empty($initialDiagnosisRemarks)){
                            $newConsultNotes->update($initialDiagnosisRemarks);
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
                        $finalDiagnosisRemarks = (array)$this->getFinalDiagnosisRemarks($consultNotes['id']);
                        if(!empty($finalDiagnosisRemarks)){
                            $newConsultNotes->update($finalDiagnosisRemarks);
                        }
                    }

                    //Save Physical Examinations
                    $notesPe = $this->getNotesPe($consultNotes['id']);
                    $resultArray = [];

                    if (!empty($notesPe)) {
                        $user_id = $notesPe->user_id ?? $consultNotes['user_id'];

                        $sections = ['skin_code', 'heent_code', 'chest_code', 'heart_code', 'abdomen_code', 'extremities_code'];

                        foreach ($sections as $section) {
                            if (!empty($notesPe->$section)) {
                                $sectionRecords = array_map('strtoupper', explode(',', $notesPe->$section));
                                $sectionRecords = array_map(function ($pe_id) use ($section) {
                                    if ($section === 'chest_code') {
                                        $pe_id = str_replace('/LUNGS', '', $pe_id);
                                    }
                                    return compact('pe_id');
                                }, $sectionRecords);
                                $sectionRecords = array_map(function ($item) use ($newConsultNotes, $user_id, $database) {
                                    return array_merge($item, ['notes_id' => $newConsultNotes->id, 'user_id' => $user_id, 'facility_code' => $database]);
                                }, $sectionRecords);
                                $resultArray = array_merge($resultArray, $sectionRecords);
                            }
                        }

                        if(!empty($notesPe->breast_remarks) || !empty($notesPe->skin_remarks) || !empty($notesPe->heent_remarks) || !empty($notesPe->chest_remarks) ||!empty($notesPe->heart_remarks) || !empty($notesPe->abdomen_remarks) || !empty($notesPe->extremities_remarks)){
                            ConsultPeRemarks::query()->updateOrCreate([
                                'notes_id' => $newConsultNotes->id,
                                'patient_id' =>$consult['patient_id']
                            ], [
                                'user_id' => $user_id,
                                'facility_code' => $database,
                                'breast_remarks' => $notesPe->breast_remarks,
                                'skin_remarks' => $notesPe->skin_remarks,
                                'heent_remarks'  => $notesPe->heent_remarks,
                                'chest_remarks' => $notesPe->chest_remarks,
                                'heart_remarks' => $notesPe->heart_remarks,
                                'abdomen_remarks' => $notesPe->abdomen_remarks,
                                'extremities_remarks' => $notesPe->extremities_remarks
                            ]);
                        }
                    }

                    // Continue with the rest of the code to avoid duplicates and perform upsert
                    $existingRecords = ConsultNotesPe::whereIn('notes_id', array_column($resultArray, 'notes_id'))
                        ->whereIn('pe_id', array_column($resultArray, 'pe_id'))
                        ->get();

                    $existingKeys = $existingRecords->map(function ($record) {
                        return ['notes_id' => $record->notes_id, 'pe_id' => $record->pe_id];
                    })->toArray();

                    $uniqueRecords = collect($resultArray)->reject(function ($record) use ($existingKeys) {
                        return in_array(['notes_id' => $record['notes_id'], 'pe_id' => $record['pe_id']], $existingKeys);
                    });

                    ConsultNotesPe::query()->upsert($uniqueRecords->toArray(), ['notes_id', 'pe_id']);

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

    public function getMedicinePrescription()
    {
        return DB::connection('mysql_migration')->table('drug_prescription')
            ->selectRaw('
                drug_prescription.id AS id,
                consult.wahtermelon_consult_id AS consult_id,
                patient.wahtermelon_patient_id AS patient_id,
                user.wahtermelon_user_id AS user_id,
                hprodid AS medicine_code,
                drug_added AS added_medicine,
                prescription_date,
                dosage_qty AS dosage_quantity,
                CASE
                    WHEN dosage_uom = "tbs" THEN "T, tbs"
                    WHEN dosage_uom = "tsp" THEN "t, tsp"
                    ELSE dosage_uom
                END AS dosage_uom,
                dose_regimen,
                medicine_purpose,
                purpose_other,
                duration_intake,
                duration_frequency,
                quantity,
                quantity_uom AS quantity_preparation,
                prescription_remarks AS remarks,
                drug_prescription.created_at AS created_at,
                drug_prescription.updated_at AS updated_at
            ')
            ->join('user AS user', function ($join) {
                $join->on('drug_prescription.user_id', '=', 'user.id')
                    ->whereNotNull('user.wahtermelon_user_id');
            })
            ->join('patient', function ($join) {
                $join->on('drug_prescription.patient_id', '=', 'patient.id')
                    ->whereNotNull('patient.wahtermelon_patient_id');
            })
            ->join('consult', function ($join) {
                $join->on('drug_prescription.consult_id', '=', 'consult.id')
                    ->whereNotNull('consult.wahtermelon_consult_id');
            })
            ->whereNull('wahtermelon_prescription_id')
            ->get();
    }

    private  function savePrescription($prescriptions, $database, $connectionName)
    {
        $prescriptionsCount = count($prescriptions);
        if ($prescriptionsCount < 1) {
            $this->components->info('Nothing to migrate');
            return;
        }
        //Delete duplicate dispensing records
        $this->deleteDuplicateDispensingRecords($connectionName);

        $prescriptionBar = $this->output->createProgressBar($prescriptionsCount);
        $prescriptionBar->setFormat('Processing Prescription Table: %current%/%max% [%bar%] %percent:3s%% Elapsed: %elapsed:6s% Remaining: %remaining:6s% Estimated: %estimated:-6s%');
        $prescriptionBar->start();
        $startTime = time();

        $chunkSize = 200; // Set your desired chunk size
        $chunks = array_chunk($prescriptions->toArray(), $chunkSize);

        foreach ($chunks as $chunk) {
            foreach ($chunk as $prescriptionData) {
                $prescription = (array) $prescriptionData;

                DB::transaction(function () use ($prescription, $database, $connectionName) {
                    $keysToRemoveIfEmpty = ['medicine_code', 'added_medicine', 'purpose_other', 'remarks'];

                    foreach ($keysToRemoveIfEmpty as $key) {
                        if (empty($prescription[$key])) {
                            Arr::pull($prescription, $key);
                        }
                    }

                    $data = [
                        'patient_id' => $prescription['patient_id'],
                        'consult_id' => $prescription['consult_id'],
                    ];

                    foreach (['medicine_code', 'added_medicine'] as $key) {
                        if (!empty($prescription[$key])) {
                            $data[$key] = $prescription[$key];
                        }
                    }
                    $prescribedBy = DB::connection($connectionName)->table('user')->selectRaw('wahtermelon_user_id AS prescribed_by')->whereNotNull('wahtermelon_user_id')->whereDesignation('MD')->first();

                    if ($prescribedBy) {
                        $prescription['prescribed_by'] = $prescribedBy->prescribed_by;
                    }

                    $newPrescription = MedicinePrescription::query()
                        ->updateOrCreate($data, $prescription + ['facility_code' => $database]);

                    DB::connection($connectionName)->table('drug_prescription')->whereId($prescription['id'])->update(['wahtermelon_prescription_id' => $newPrescription->id]);
                    $dispensing = $this->getMedicineDispensing($prescription['id']);
                    if (!empty($dispensing)) {
                        $this->saveDispensing($dispensing, $newPrescription->id, $prescription['patient_id'], $database);
                    }

                });

                $prescriptionBar->advance();
            }
        }

        $prescriptionBar->finish();
        $endTime = time();
        $elapsedTime = $endTime - $startTime;

        $this->newLine();
        $this->components->twoColumnDetail('Prescription Migration', 'Done');
        $this->newLine();
        $this->line('Elapsed Time: ' . gmdate('H:i:s', $elapsedTime));


    }

    public function getMedicineDispensing($prescriptionId)
    {
        return DB::connection('mysql_migration')->table('drug_dispensing')
            ->selectRaw('
                drug_dispensing.id AS id,
                user.wahtermelon_user_id AS user_id,
                dispense_date AS dispensing_date,
                dispense_quantity,
                remarks,
                drug_dispensing.created_at,
                drug_dispensing.updated_at
            ')
            ->join('user AS user', function ($join) {
                $join->on('drug_dispensing.user_id', '=', 'user.id')
                    ->whereNotNull('user.wahtermelon_user_id');
            })
            ->where('prescription_id', $prescriptionId)
            ->whereNull('drug_dispensing.deleted_at')
            ->get();
    }

    public function saveDispensing($data, $prescriptionId, $patientId, $facilityCode)
    {
        foreach($data as $dispensing){
            $dispensing = (array) $dispensing;
            MedicineDispensing::query()
                ->updateOrCreate(['dispensing_date' => $dispensing['dispensing_date'], 'patient_id' => $patientId, 'prescription_id' => $prescriptionId], $dispensing + ['facility_code' => $facilityCode]);
        }
    }

    public function deleteDuplicateDispensingRecords($connectionName)
    {
        $duplicateRows = DB::connection($connectionName)->table('drug_dispensing')
            ->select('prescription_id', DB::raw('COUNT(*) as count, DATE_FORMAT(created_at, "%Y-%m-%d %H:%i:%s") as created_at_formatted'))
            ->groupBy('prescription_id', 'created_at_formatted')
            ->having('count', '>', 1)
            ->get();

        // Step 2: Delete Duplicates Except One
        foreach ($duplicateRows as $row) {
            $idsToDelete = DB::connection($connectionName)
                ->table('drug_dispensing AS d1')
                ->select('d1.id')
                ->where('d1.prescription_id', $row->prescription_id)
                ->where('d1.created_at', $row->created_at_formatted)
                ->whereExists(function ($query) use ($row) {
                    $query->select(DB::raw(1))
                        ->from('drug_dispensing AS d2')
                        ->whereRaw('d1.prescription_id = d2.prescription_id')
                        ->whereRaw('d1.created_at = d2.created_at')
                        ->whereRaw('d1.id > d2.id');
                })
                ->get()
                ->pluck('id');

            DB::connection($connectionName)
                ->table('drug_dispensing')
                ->whereIn('id', $idsToDelete)
                ->delete();
        }
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

        try {
            Schema::connection($connectionName)->table('drug_prescription', function (Blueprint $table) {
                $table->string('wahtermelon_prescription_id')->nullable()->after('id');
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
