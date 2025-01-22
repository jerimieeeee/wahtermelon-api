<?php

namespace App\Http\Controllers\API\V1\Import;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessCsvJob;
use App\Jobs\ProcessCsvSpecificJob;
use App\Jobs\UploadCsvJob;
use App\Models\User;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Medicine\MedicineList;
use App\Models\V1\Patient\Patient;
use App\Models\V1\Patient\PatientVitals;
use App\Models\V1\PSGC\Barangay;
use App\Services\Patient\PatientVitalsService;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\SimpleExcel\SimpleExcelReader;

class ImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx',
        ]);

        $file = $request->file('file');

        // Move the file to a permanent location
        $filePath = $file->store('temp'); // Stored in storage/app/temp

        // Get the absolute path to the stored file
        $absolutePath = storage_path('app/' . $filePath);

        // Process the file with Spatie Simple Excel
        $rows = SimpleExcelReader::create($absolutePath)
            ->getRows();
        //dd($rows);
        $rows->chunk(1000)->each(function ($chunk) {
            $chunk->each(function (array $row) {
                foreach ($row as $key => $value) {
                    // Detect scientific notation and convert it
                    if (is_string($value) && preg_match('/[0-9]+(\.[0-9]+)?E[+-][0-9]+/', $value)) {
                        $row[$key] = number_format((float) $value, 0, '', ''); // Convert to full number as text
                    }
                }
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
                        //dd('ok');
                    }
                }
                /* if ($row['MEDICINE LIST ID'] == 'NA') {
                    dd($row['MEDICINE LIST ID']);
                } */
                /* $medicineList = explode(',', $row['MEDICINE LIST ID']);
                    foreach ($medicineList as $key => $medicineId) {
                        // dd($medicineId);
                        $data = MedicineList::query()
                            ->find($medicineId)
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
                            ->first();
                        $prescription = $data->toArray();
                        $prescriptionData = array_filter($prescription, function ($value) {
                            return $value !== null && $value !== "";
                        });
                        dd($prescriptionData);
                    }
                $randomUser = User::query()->where('facility_code', 'DOH000000000048882')->where('is_active', 1)->where('designation_code', '!=', 'MD')->inRandomOrder()->first();

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
                    $years = Carbon::parse($patient->birthdate)->diffInYears($row['VITALS DATE 1st']);
                    $months = Carbon::parse($patient->birthdate)->diffInMonths($row['VITALS DATE 1st']);
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

                    if (Str::contains($row['FINAL DIAGNOSIS'], ';')) {
                        $icd10s = array_map('trim', explode(';', $row['FINAL DIAGNOSIS'])); // Split and trim
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

                    $physicalExams = ['ABDOMEN12', 'CHEST06', 'GENITOURINARY01', 'HEART05', 'NEURO06', 'RECTAL01', 'SKIN15'];
                    foreach ($physicalExams as $pe)
                        $notes->physicalExam()->create([
                            'facility_code' => 'DOH000000000048882',
                            'user_id' => $randomUser->id,
                            'pe_id' => $pe
                        ]);

                    //dd($finalDx);

                }
                dd('done'); */
            });
        });

        Storage::delete($filePath);
//        $rows->chunk(1000)->each(function ($chunk) {
//            $chunk->each(function (array $row) {
//                dd($row);
//            });
//        });

        return 'Data imported successfully!';
    }

    public function importCsv(Request $request)
    {
        /* $request->validate([
            'file' => 'required|file|mimes:csv,xlsx',
        ]);

        $file = $request->file('file');

        // Move the file to a permanent location
        $filePath = $file->store('temp'); // Stored in storage/app/temp

        // Get the absolute path to the stored file
        $absolutePath = storage_path('app/' . $filePath);

        // Process the file with Spatie Simple Excel
        $rows = SimpleExcelReader::create($absolutePath)
            ->getRows();

        $batch = Bus::batch([])->dispatch();

        $rows->chunk(500)->each(function ($chunk) use ($batch) {
            $batch->add(new UploadCsvJob($chunk->toArray()));
        });

        // Delete the file after processing
        Storage::delete($filePath);

        return response()->json([
            'message' => 'Import batch dispatched successfully!',
            'batch_id' => $batch->id,
        ]); */
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx',
        ]);

        $file = $request->file('file');

        // Move the file to a permanent location
        $filePath = $file->store('temp'); // Stored in storage/app/temp

        // Dispatch a job to handle the import process
        ProcessCsvJob::dispatch($filePath);

        return response()->json([
            'message' => 'Import job dispatched successfully!',
        ]);
    }

    public function importCsvSpecific(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx',
        ]);

        $file = $request->file('file');

        // Move the file to a permanent location
        $filePath = $file->store('temp'); // Stored in storage/app/temp

        // Dispatch a job to handle the import process
        ProcessCsvSpecificJob::dispatch($filePath);

        return response()->json([
            'message' => 'Import job dispatched successfully!',
        ]);
    }
}
