<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Medicine\MedicineList;
use App\Models\V1\Patient\Patient;
use App\Models\V1\Patient\PatientVitals;
use App\Models\V1\PSGC\Barangay;
use App\Services\Patient\PatientVitalsService;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class UploadCsvJob implements ShouldQueue, ShouldBeUniqueUntilProcessing
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
            foreach ($row as $key => $value) {
                // Detect scientific notation and convert it
                if (is_string($value) && preg_match('/[0-9]+(\.[0-9]+)?E[+-][0-9]+/', $value)) {
                    $row[$key] = number_format((float) $value, 0, '', ''); // Convert to full number as text
                }
            }
            list($last_name, $first_name) = explode(',', $row['ENCODER']);
            //$randomUser = User::query()->where('facility_code', 'DOH000000000048882')->where('is_active', 1)->where('designation_code', '!=', 'MD')->inRandomOrder()->first();
            $randomUser = User::query()->where('last_name', $last_name)->where('first_name', trim($first_name))->where('facility_code', 'DOH000000000048882')->first();
            //dd($randomUser->konsultaCredential->accreditation_number);
            //dd($row);
            $row['BIRTHDATE'] = Carbon::parse($row['BIRTHDATE'])->format('Y-m-d');
            $consultDate = Carbon::parse($row['CONSULTATION DATE'])
                ->setTime(rand(9, 16), rand(0, 59), rand(0, 59)); // Set a random time between 9:00:00 and 16:59:59
            //->format('Y-m-d H:i:s');
            $row['CONSULTATION DATE'] = $consultDate->format('Y-m-d H:i:s');
            $row['VITALS DATE 1st'] = $consultDate->addMinutes(5)->format('Y-m-d H:i:s');
            $row['VITALS DATE 2nd'] = $consultDate->addMinutes(5)->format('Y-m-d H:i:s');

            $patient = Patient::query()->where([
                'last_name' => $row['LAST NAME'],
                'first_name' => $row['FIRST NAME'],
                'middle_name' => $row['MIDDLE NAME'],
                'suffix_name' => $row['SUFFIX'],
                'birthdate' => $row['BIRTHDATE'],
            ])->first();

            if(!$patient) {
                $caseNumberDate = Carbon::parse($row['ENLISTMENT DATE'])->format('Ym');
                $caseNumberPrefix = 'T' . $randomUser->konsultaCredential->accreditation_number . $caseNumberDate;
                $caseNumber = IdGenerator::generate(['table' => 'patients', 'field' => 'case_number', 'length' => 21, 'prefix' => $caseNumberPrefix, 'reset_on_prefix_change' => true]);
                $patient = Patient::query()->updateOrCreate(
                    [
                        'last_name' => $row['LAST NAME'],
                        'first_name' => $row['FIRST NAME'],
                        'middle_name' => $row['MIDDLE NAME'],
                        'suffix_name' => $row['SUFFIX'],
                        'birthdate' => $row['BIRTHDATE'],
                    ],
                    [
                        'facility_code' => 'DOH000000000048882',
                        'case_number' => $caseNumber,
                        'user_id' => $randomUser->id,
                        'mothers_name' => $row["MOTHER'S MAIDEN NAME"],
                        'gender' => $row["SEX"],
                        'mobile_number' => $row["MOBILE NUMBER"],
                        'pwd_type_code' => $row["PWD"],
                        'indegenous_flag' => 0,
                        'blood_type_code' => $row['BLOOD TYPE'],
                        'religion_code' => $row['RELIGION'],
                        'occupation_code' => $row['OCCUPATION'],
                        'education_code' => $row['EDUCATION'],
                        'civil_status_code' => $row['CIVIL STATUS'],
                        'consent_flag' => 1,
                    ]
                );

            }

            if ($patient->socialHistory == null) {
                $row['SMOKING'] = $row['SMOKING'] == 'NO' ? 'N' : 'Y';
                $row['ALCOHOL'] = $row['ALCOHOL'] == 'NO' ? 'N' : 'Y';
                $row['ILLICIT DRUGS'] = $row['ILLICIT DRUGS'] == 'NO' ? 'N' : 'Y';
                $row['SEXUALLY ACTIVE'] = $row['SEXUALLY ACTIVE'] == 'NO' ? 'N' : 'Y';

                $patient->socialHistory()->create([
                    'facility_code' => 'DOH000000000048882',
                    'user_id' => $randomUser->id,
                    'patient_id' => $patient->id,
                    'smoking' => $row['SMOKING'],
                    'alcohol' => $row['ALCOHOL'],
                    'illicit_drugs' => $row['SMOKING'],
                    'sexually_active' => $row['SMOKING'],
                ]);
                //dd('social');
            }

            if ($patient->patientHistory->isEmpty()) {
                $patient->patientHistory()->create([
                    'facility_code' => 'DOH000000000048882',
                    'user_id' => $randomUser->id,
                    'patient_id' => $patient->id,
                    'medical_history_id' => 20,
                    'category' => 1
                ]);
            }

            if ($patient->familyHistory->isEmpty()) {
                $patient->patientHistory()->create([
                    'facility_code' => 'DOH000000000048882',
                    'user_id' => $randomUser->id,
                    'patient_id' => $patient->id,
                    'medical_history_id' => 20,
                    'category' => 2
                ]);
            }

            //dd($patient->householdFolder->id);
            if ($patient->householdFolder === null) {
                $barangay = Barangay::query()->where('psgc_10_digit_code', 'LIKE', '%'.$row['ADDRESS'])->first();
                $patient->householdFolder()->create([
                    'facility_code' => 'DOH000000000048882',
                    'user_id' => $randomUser->id,
                    'address' => 'Purok 1',
                    'barangay_code' => $barangay->psgc_10_digit_code
                ])->householdMember()->create(['patient_id' => $patient->id, 'user_id' => $randomUser->id, 'family_role_code' => $row['FAMILY ROLE']]);
            }

            if ($patient->philhealthLatest === null) {
                $philhealthTransactionDate = Carbon::parse($row['ENLISTMENT DATE'])->format('Ym');
                $row['ENLISTMENT DATE'] = Carbon::parse($row['ENLISTMENT DATE'])->format('Y-m-d');
                $row['EFFECTIVITY YEAR'] = Carbon::parse($row['ENLISTMENT DATE'])->format('Y');

                $philhealthPrefix = $randomUser->konsultaCredential->accreditation_number . $philhealthTransactionDate;
                $philhealthTransactionNumber = IdGenerator::generate(['table' => 'patient_philhealth', 'field' => 'transaction_number', 'length' => 21, 'prefix' => $philhealthPrefix, 'reset_on_prefix_change' => true]);
                $patient->philhealthLatest()->create([
                    'facility_code' => 'DOH000000000048882',
                    'transaction_number' => $philhealthTransactionNumber,
                    'patient_id' => $patient->id,
                    'philhealth_id' => $row['PHIC ID'],
                    'user_id' => $randomUser->id,
                    'enlistment_date' => $row['ENLISTMENT DATE'],
                    'effectivity_year' => $row['EFFECTIVITY YEAR'],
                    'enlistment_status_id' => 1,
                    'package_type_id' => 'K',
                    'membership_type_id' => $row['MEMBERSHIP TYPE'],
                    'membership_category_id' => $row['MEMBERSHIP CATEGORY'],
                ]);
            }

            //dd($row);
            $consult = Consult::query()
                ->where(['patient_id' => $patient->id, 'pt_group' => 'cn'])
                ->whereDate('consult_date', Carbon::parse($row['CONSULTATION DATE'])->format('Y-m-d'))->first();

            if (!$consult) {
                $patientVitals = new PatientVitalsService();
                $years = Carbon::parse($patient->birthdate)->diffInYears($row['VITALS DATE 1st'], true);
                $months = Carbon::parse($patient->birthdate)->diffInMonths($row['VITALS DATE 1st'], true);
                //dd(['Years' => $years, 'Months' => $months, 'Birthdate' => $patient, 'Vitals Date' => $row['VITALS DATE 1st']]);
                $bp1 = explode('/',$row['BP1']);
                $bp2 = explode('/',$row['BP2']);

                $firstVitalDetails = [
                    'facility_code' => 'DOH000000000048882',
                    'user_id' => $randomUser->id,
                    'patient_id' => $patient->id,
                    'patient_age_years' => $years,
                    'patient_age_months' => $months,
                    'patient_temp' => $row['TEMP'],
                    'patient_height' => $row['HT (CM)'],
                    'patient_weight' => $row['WT (KG)'],
                    'patient_heart_rate' => $row['HR/CR'],
                    'patient_respiratory_rate' => $row['RR'],
                    'patient_pulse_rate' => $row['PR'],
                    'patient_spo2' => $row['SPO2'],
                    'patient_waist' => $row['WAISTC (CM)'] === 'NA' ? null : $row['WAISTC (CM)'],
                    'patient_hip' => $row['HIPC (CM)'] === 'NA' ? null : $row['HIPC (CM)'],
                    'patient_muac' => $row['MUAC (CM)'] === 'NA' ? null : $row['MUAC (CM)'],
                ];

                if ($years > 6) {
                    //dd($row['WT (KG)'], $row['HT (CM)']);
                    [$bmi, $bmiClass] = compute_bmi($row['WT (KG)'], $row['HT (CM)']);
                    $firstVitalDetails['patient_bmi'] = $bmi;
                    $firstVitalDetails['patient_bmi_class'] = $bmiClass;
                }
                if ($months < 72) {
                    $weightForAge = $patientVitals->get_weight_for_age($months, $patient->gender, $row['WT (KG)']);
                    $weightForAgeClass = $weightForAge ? $weightForAge->wt_class : null;

                    $heightForAge = $patientVitals->get_height_for_age($months, $patient->gender, $row['HT (CM)']);
                    $heightForAgeClass = $heightForAge ? $heightForAge->lt_class : null;

                    $weightForHeight = $patientVitals->get_weight_for_height($months, $patient->gender, $row['WT (KG)'], $row['HT (CM)']);
                    $weightForHeightClass = $weightForHeight ? $weightForHeight->wt_class : null;

                    $firstVitalDetails['patient_weight_for_age'] = $weightForAgeClass;
                    $firstVitalDetails['patient_height_for_age'] = $heightForAgeClass;
                    $firstVitalDetails['patient_weight_for_height'] = $weightForHeightClass;
                }

                $consultTransactionDate = Carbon::parse($row['CONSULTATION DATE'])->format('Ym');
                $consultPrefix = $randomUser->konsultaCredential->accreditation_number . $consultTransactionDate;
                $consultTransactionNumber = IdGenerator::generate(['table' => 'consults', 'field' => 'transaction_number', 'length' => 21, 'prefix' => $consultPrefix, 'reset_on_prefix_change' => true]);

                $consult = Consult::query()->create([
                    'facility_code' => 'DOH000000000048882',
                    'transaction_number' => $consultTransactionNumber,
                    'user_id' => $randomUser->id,
                    'patient_id' => $patient->id,
                    'is_konsulta' => 1,
                    'physician_id' => '9b0665bf-f899-4b1e-bbdb-b2d7da0d880e',
                    'consult_date' => $row['CONSULTATION DATE'],
                    'consult_done' => 1,
                    'pt_group' => 'cn'
                ]);

                $firstVitalDetails['consult_id'] = $consult->id;

                $vitals1 = PatientVitals::query()->create([
                        'vitals_date' => $row['VITALS DATE 1st'],
                        'bp_systolic' => $bp1[0],
                        'bp_diastolic' => $bp1[1],
                    ] + $firstVitalDetails);

                $vitals2 = PatientVitals::query()->create([
                        'vitals_date' => $row['VITALS DATE 2nd'],
                        'bp_systolic' => $bp2[0],
                        'bp_diastolic' => $bp2[1],
                    ] + $firstVitalDetails);

                $notes = $consult->consultNotes()->create([
                    'facility_code' => 'DOH000000000048882',
                    'user_id' => $randomUser->id,
                    'patient_id' => $patient->id,
                    'complaint' => $row['COMPLAINT NOTES'],
                    'history' => $row['HISTORY NOTES'],
                    'general_survey_code' => $row['GENERAL SURVEY'],
                ]);

                $complaint = $notes->complaints()->create([
                    'facility_code' => 'DOH000000000048882',
                    'user_id' => $randomUser->id,
                    'consult_id' => $consult->id,
                    'patient_id' => $patient->id,
                    'complaint_id' => $row['CHIEF COMPLAINT'] == 'OTEHRS' ? 'OTHERS' : $row['CHIEF COMPLAINT']
                ]);

                $management = $notes->management()->create([
                    'facility_code' => 'DOH000000000048882',
                    'user_id' => $randomUser->id,
                    'patient_id' => $patient->id,
                    'management_code' => $row['MGMT/COUNSELLING'],
                ]);

                if (Str::contains($row['FINAL DIAGNOSIS'], [';', ','])) {
                    //$icd10s = array_map('trim', explode(';', $row['FINAL DIAGNOSIS'])); // Split and trim
                    $icd10s = array_map('trim', preg_split('/[;,]/', $row['FINAL DIAGNOSIS']));
                    foreach ($icd10s as $icd10) {
                        $finalDx = $notes->finaldx()->create([
                            'facility_code' => 'DOH000000000048882',
                            'user_id' => '9b0665bf-f899-4b1e-bbdb-b2d7da0d880e',
                            'icd10_code' => $icd10
                        ]);
                    }
                } else {
                    $finalDx = $notes->finaldx()->create([
                        'facility_code' => 'DOH000000000048882',
                        'user_id' => '9b0665bf-f899-4b1e-bbdb-b2d7da0d880e',
                        'icd10_code' => $row['FINAL DIAGNOSIS']
                    ]);
                }

                $physicalExams = ['ABDOMEN12', 'CHEST06', 'GENITOURINARY01', 'HEART05', 'NEURO06', 'RECTAL01', 'SKIN15', 'HEENT11'];
                foreach ($physicalExams as $pe)
                    $notes->physicalExam()->create([
                        'facility_code' => 'DOH000000000048882',
                        'user_id' => $randomUser->id,
                        'pe_id' => $pe
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
                        /* if(!$data) {
                            Log::warning("Medicine ID not found", [
                                'medicine_id' => $medicineId,
                                'row' => $row,
                            ]);
                            continue;
                        } */
                        $prescription = $data->toArray();
                        $prescriptionData = array_filter($prescription, function ($value) {
                            return $value !== null && $value !== "";
                        });
                        $prescriptionData['user_id'] = $randomUser->id;
                        $prescriptionData['patient_id'] = $patient->id;
                        //$prescriptionData['consult_id'] = $consult->id;
                        $prescriptionData['prescribed_by'] = '9b0665bf-f899-4b1e-bbdb-b2d7da0d880e';
                        $prescriptionData['prescription_date'] = $row['PRESCRIPTION DATE'];
                        $prescribeMedicine = $consult->prescription()->create($prescriptionData);

                        $dispenseMedicine = [
                            'facility_code' => 'DOH000000000048882',
                            'user_id' => $randomUser->id,
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
                        'user_id' => $randomUser->id,
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
                            'user_id' => $randomUser->id,
                            'patient_id' => $patient->id,
                            'laboratory_date' => $row['LABORATORY DATE'],
                            'lab_status_code' => 'D',
                            'hemoglobin' => $row['CBC: HGB'],
                            'hematocrit' => $row['CBC: HCT'],
                            'rbc' => $row['CBC: RBC'],
                            'wbc' => $row['CBC: WBC'],
                            'neutrophils' => $row['CBC: SEG'],
                            'lymphocytes' => $row['CBC: LYM'],
                            'monocytes' => $row['CBC: MON'],
                            'platelets' => $row['CBC: PLT'],
                        ]);
                    }

                    if ($lab === 'BCHM') {
                        $labRequest->bloodchem()->create([
                            'facility_code' => 'DOH000000000048882',
                            'consult_id' => $consult->id,
                            'user_id' => $randomUser->id,
                            'patient_id' => $patient->id,
                            'laboratory_date' => $row['LABORATORY DATE'],
                            'lab_status_code' => 'D',
                            'fbs' => $row['CHEM: FBS'],
                            'creatinine' => $row['CHEM: CREA'],
                            'ldl' => $row['CHEM: LDL'],
                            'hdl' => $row['CHEM: HDL'],
                            'cholesterol' => $row['CHEM: TC'],
                            'triglycerides' => $row['CHEM: TG'],
                        ]);
                    }

                    if ($lab === 'URN') {
                        $labRequest->urinalysis()->create([
                            'facility_code' => 'DOH000000000048882',
                            'consult_id' => $consult->id,
                            'user_id' => $randomUser->id,
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
                            'user_id' => $randomUser->id,
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
                            'user_id' => $randomUser->id,
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
                            'user_id' => $randomUser->id,
                            'patient_id' => $patient->id,
                            'laboratory_date' => $row['LABORATORY DATE'],
                            'lab_status_code' => 'D',
                            'findings_code' => $findingsCode,
                            'remarks_findings' => $row['CXR'],
                        ]);
                    }
                }

            }
        }
    }
}
