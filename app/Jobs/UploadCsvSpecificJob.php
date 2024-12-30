<?php

namespace App\Jobs;

use App\Models\V1\Consultation\Consult;
use App\Models\V1\Medicine\MedicineList;
use App\Models\V1\Patient\Patient;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UploadCsvSpecificJob implements ShouldQueue, ShouldBeUniqueUntilProcessing
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public $chunk;
    public $timeout = 1000;
    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $retryAfter = 60;
    /**
     * Create a new job instance.
     */
    public function __construct(array $chunk)
    {
        $this->chunk = $chunk;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->chunk as $row) {
            $patient = Patient::query()->where([
                'last_name' => $row['LAST NAME'],
                'first_name' => $row['FIRST NAME'],
                'middle_name' => $row['MIDDLE NAME'],
                'suffix_name' => $row['SUFFIX'],
                'birthdate' => $row['BIRTHDATE'],
            ])->first();

            if ($patient) {
                $consultDate = Carbon::parse($row['CONSULTATION DATE'])->format('Y-m-d');
                $consult = Consult::query()
                ->where(['patient_id' => $patient->id, 'pt_group' => 'cn', 'is_konsulta' => 1])
                ->whereDate('consult_date', $consultDate)->first();
                if ($consult) {
                    $medicineList = explode(',', $row['MEDICINE LIST ID']);
                        $dispenseList = explode(',', $row['DISPENSE QUANTITY']);
                        $medicines = [];
                        foreach ($medicineList as $key => $medicineId) {
                            // dd($medicineId);
                            $data = MedicineList::query()
                            ->select(
                                "facility_code",
                                "brand_name",
                                "medicine_code",
                                "konsulta_medicine_code",
                                "added_medicine",
                                "dosage_quantity",
                                "dosage_uom",
                                "dose_regimen",
                                "instruction_quantity",
                                "medicine_purpose",
                                "purpose_other",
                                "duration_intake",
                                "duration_frequency",
                                "quantity",
                                "quantity_preparation",
                                "medicine_route_code",
                            )
                            ->find($medicineId);
                            if(!$data) {
                                Log::warning("Medicine ID not found", [
                                    'medicine_id' => $medicineId,
                                    'row' => $row,
                                ]);
                            }
                        }
                    $physicalExams = ['ABDOMEN12', 'CHEST06', 'GENITOURINARY01', 'HEART05', 'NEURO06', 'RECTAL01', 'SKIN15', 'HEENT11'];
                        foreach ($physicalExams as $pe) {
                            $consult->consultNotes->physicalExam()->updateOrCreate([
                                'facility_code' => 'DOH000000000048882',
                                'user_id' => $patient->user_id,
                                'pe_id' => $pe
                            ], ['pe_id' => $pe]);
                        }
                    $consult->consultNotes->management()->updateOrCreate([
                        'facility_code' => 'DOH000000000048882',
                        'patient_id' => $patient->id,
                        'management_code' => $row['MGMT/COUNSELLING'],
                    ], [
                        'user_id' => $patient->user_id,
                        'management_code' => $row['MGMT/COUNSELLING']
                    ]);

                    if($consult->prescription()->doesntExist() && $row['MEDICINE LIST ID'] != 'NA') {
                        $medicineList = explode(',', $row['MEDICINE LIST ID']);
                        $dispenseList = explode(',', $row['DISPENSE QUANTITY']);
                        foreach ($medicineList as $key => $medicineId) {
                            // dd($medicineId);
                            $data = MedicineList::query()
                            ->select(
                                "facility_code",
                                "brand_name",
                                "medicine_code",
                                "konsulta_medicine_code",
                                "added_medicine",
                                "dosage_quantity",
                                "dosage_uom",
                                "dose_regimen",
                                "instruction_quantity",
                                "medicine_purpose",
                                "purpose_other",
                                "duration_intake",
                                "duration_frequency",
                                "quantity",
                                "quantity_preparation",
                                "medicine_route_code",
                            )
                            ->find($medicineId);

                            if(!$data) {
                                dd([$patient, $medicineId]);
                            }
                            $prescription = $data->toArray();
                            $prescriptionData = array_filter($prescription, function ($value) {
                                return $value !== null && $value !== "";
                            });
                            $prescriptionData['user_id'] = $patient->user_id;
                            $prescriptionData['patient_id'] = $patient->id;
                            //$prescriptionData['consult_id'] = $consult->id;
                            $prescriptionData['prescribed_by'] = '9b0665bf-f899-4b1e-bbdb-b2d7da0d880e';
                            $prescriptionData['prescription_date'] = $row['PRESCRIPTION DATE'];
                            $prescribeMedicine = $consult->prescription()->create($prescriptionData);

                            $dispenseMedicine = [
                                'facility_code' => 'DOH000000000048882',
                                'user_id' => $patient->user_id,
                                'patient_id' => $patient->id,
                                'dispensing_date' => $row['DISPENSING DATE'],
                                'dispense_quantity' => $dispenseList[$key],
                                'remarks' => 'NA'
                            ];
                            $prescribeMedicine->dispensing()->create($dispenseMedicine);
                        }
                    }

                    $laboratories = array_map('trim', explode('/', $row['LABORATORY']));
                    foreach ($laboratories as $lab) {
                        $lab = match ($lab) {
                            'CHEM' => 'BCHM',
                            'UA' => 'URN',
                            'SE' => 'FCAL',
                            'CXR' => 'CXRAY',
                            default => $lab,
                        };

                        $labRequest = $consult->consultLaboratory()->create([
                            'facility_code' => 'DOH000000000048882',
                            'consult_id' => $consult->id,
                            'user_id' => $patient->user_id,
                            'patient_id' => $patient->id,
                            'request_date' => $row['LABORATORY DATE'],
                            'lab_code' => $lab,
                            'recommendation_code' => 'Y',
                            'request_status_code' => 'RQ'
                        ]);

                        if ($lab === 'CBC') {
                            $labRequest->cbc()->create([
                                'facility_code' => 'DOH000000000048882',
                                'consult_id' => $consult->id,
                                'user_id' => $patient->user_id,
                                'patient_id' => $patient->id,
                                'laboratory_date' => $row['LABORATORY DATE'],
                                'lab_status_code' => 'D',
                                'hemoglobin' => round((float)$row['CBC: HGB'],2),
                                'hematocrit' => round((float)$row['CBC: HCT'],2),
                                'rbc' => round((float)$row['CBC: RBC'],2),
                                'wbc' => round((float)$row['CBC: WBC'],2),
                                'neutrophils' => round((float)$row['CBC: SEG'],2),
                                'lymphocytes' => round((float)$row['CBC: LYM'],2),
                                'monocytes' => round((float)$row['CBC: MON'],2),
                                'platelets' => round((float)$row['CBC: PLT'],2),
                            ]);
                        }

                        if ($lab === 'BCHM') {
                            $labRequest->bloodchem()->create([
                                'facility_code' => 'DOH000000000048882',
                                'consult_id' => $consult->id,
                                'user_id' => $patient->user_id,
                                'patient_id' => $patient->id,
                                'laboratory_date' => $row['LABORATORY DATE'],
                                'lab_status_code' => 'D',
                                'fbs' => round((float)$row['CHEM: FBS'],2),
                                'creatinine' => round((float)$row['CHEM: CREA'],2),
                                'ldl' => round((float)$row['CHEM: LDL'],2),
                                'hdl' => round((float)$row['CHEM: HDL'],2),
                                'cholesterol' => round((float)$row['CHEM: TC'],2),
                                'triglycerides' => round((float)$row['CHEM: TG'],2),
                            ]);
                        }

                        if ($lab === 'URN') {
                            $labRequest->urinalysis()->create([
                                'facility_code' => 'DOH000000000048882',
                                'consult_id' => $consult->id,
                                'user_id' => $patient->user_id,
                                'patient_id' => $patient->id,
                                'laboratory_date' => $row['LABORATORY DATE'],
                                'lab_status_code' => 'D',
                                'gravity' => $row['UA: GRAVITY'],
                                'appearance' => $row['UA: APPEARANCE'],
                                'color' => $row['UA: COLOR'],
                                'glucose' => $row['UA: GLUCOSE'],
                                'proteins' => $row['UA: PROTEIN'],
                                'ph' => $row['UA: PH'],
                                'rb_cells' => $row['UA: RBC'],
                                'wb_cells' => $row['UA: WBC'],
                                'bacteria' => $row['UA: BACTERIA'],
                            ]);
                        }

                        if ($lab === 'FCAL') {
                            $labRequest->fecalysis()->create([
                                'facility_code' => 'DOH000000000048882',
                                'consult_id' => $consult->id,
                                'user_id' => $patient->user_id,
                                'patient_id' => $patient->id,
                                'laboratory_date' => $row['LABORATORY DATE'],
                                'lab_status_code' => 'D',
                                'color_code' => $row['SE: COLOR'] == 'BROWN' ? 1 : 5,
                                'consistency_code' => $row['SE: CONSISTENCY'] == 'SOFT' ? 1 : 4,
                                'blood_code' => $row['SE: BLOOD'] == 'ABSENT' ? 'A' : 'P',
                                'rbc' => $row['SE: RBC'],
                                'wbc' => $row['SE: WBC'],
                                'ova' => $row['SE: OVA'],
                                'parasite' => $row['SE: PARASITE'],
                            ]);
                        }

                        if ($lab === 'ECG') {
                            $labRequest->ecg()->create([
                                'facility_code' => 'DOH000000000048882',
                                'consult_id' => $consult->id,
                                'user_id' => $patient->user_id,
                                'patient_id' => $patient->id,
                                'laboratory_date' => $row['LABORATORY DATE'],
                                'lab_status_code' => 'D',
                                'findings_code' => 1,
                            ]);
                        }

                        if ($lab === 'CXRAY') {
                            if ($row['CXR'] === 'NORMAL') {
                                $findingsCode = 1;
                            }
                            if ($row['CXR'] === 'BRONCHITIS') {
                                $findingsCode = 99;
                            }
                            if ($row['CXR'] === 'PNEUMONIA' || $row['CXR'] === 'PNEUMONIA, BASAL ') {
                                $findingsCode = 2;
                            }
                            $labRequest->chestXray()->create([
                                'facility_code' => 'DOH000000000048882',
                                'consult_id' => $consult->id,
                                'user_id' => $patient->user_id,
                                'patient_id' => $patient->id,
                                'laboratory_date' => $row['LABORATORY DATE'],
                                'lab_status_code' => 'D',
                                'findings_code' => $findingsCode,
                                'remarks_findings' => $row['CXR'],
                            ]);
                        }
                    }
                    //dd('ok');
                }
            }
        }
    }
}
