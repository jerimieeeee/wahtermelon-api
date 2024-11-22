<?php

namespace App\Http\Controllers\API\V1\Import;

use App\Http\Controllers\Controller;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Barangay;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
                //dd($row);
                $row['BIRTHDATE'] = Carbon::parse($row['BIRTHDATE'])->format('Y-m-d');
                $patient = Patient::query()->where([
                    'last_name' => $row['LAST NAME'],
                    'first_name' => $row['FIRST NAME'],
                    'middle_name' => $row['MIDDLE NAME'],
                    'suffix_name' => $row['SUFFIX'],
                    'birthdate' => $row['BIRTHDATE'],
                ])->first();

                if(!$patient) {
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
                            'user_id' => '9b0662cd-29d5-401d-81da-118bdefacb3a',
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
                //dd($patient->householdFolder->id);
                if ($patient->householdFolder === null) {
                    $barangay = Barangay::query()->where('psgc_10_digit_code', 'LIKE', '%'.$row['ADDRESS'])->first();
                    $patient->householdFolder()->create([
                        'facility_code' => 'DOH000000000048882',
                        'user_id' => '9b0662cd-29d5-401d-81da-118bdefacb3a',
                        'address' => 'Purok 1',
                        'barangay_code' => $barangay->psgc_10_digit_code
                    ])->householdMember()->create(['patient_id' => $patient->id, 'user_id' => '9b0662cd-29d5-401d-81da-118bdefacb3a', 'family_role_code' => $row['FAMILY ROLE']]);
                }

                if ($patient->philhealthLatest === null) {
                    $row['ENLISTMENT DATE'] = Carbon::parse($row['ENLISTMENT DATE'])->format('Y-m-d');
                    $row['EFFECTIVITY YEAR'] = Carbon::parse($row['ENLISTMENT DATE'])->format('Y');
                    $patient->philhealthLatest()->create([
                        'facility_code' => 'DOH000000000048882',
                        'patient_id' => $patient->id,
                        'philhealth_id' => $row['PHIC ID'],
                        'user_id' => '9b0662cd-29d5-401d-81da-118bdefacb3a',
                        'enlistment_date' => $row['ENLISTMENT DATE'],
                        'effectivity_year' => $row['EFFECTIVITY YEAR'],
                        'enlistment_status_id' => 1,
                        'package_type_id' => 'K',
                        'membership_type_id' => $row['MEMBERSHIP TYPE'],
                        'membership_category_id' => $row['MEMBERSHIP CATEGORY'],
                    ]);
                }
                $consultDate = Carbon::parse($row['CONSULTATION DATE'])
                    ->setTime(rand(9, 16), rand(0, 59), rand(0, 59)); // Set a random time between 9:00:00 and 16:59:59
                    //->format('Y-m-d H:i:s');
                $row['CONSULTATION DATE'] = $consultDate->format('Y-m-d H:i:s');
                $row['VITALS DATE 1st'] = $consultDate->addMinutes(5)->format('Y-m-d H:i:s');
                $row['VITALS DATE 2nd'] = $consultDate->addMinutes(5)->format('Y-m-d H:i:s');
                //dd($row);
                $consult = Consult::query()
                    ->where(['patient_id' => $patient->id, 'pt_group' => 'cn'])
                    ->whereDate('consult_date', Carbon::parse($row['CONSULTATION DATE'])->format('Y-m-d'))->first();

                if (!$consult) {
                    $consult = Consult::query()->create([
                        'facility_code' => 'DOH000000000048882',
                        'user_id' => '9b0662cd-29d5-401d-81da-118bdefacb3a',
                        'patient_id' => $patient->id,
                        'is_konsulta' => 1,
                        'physician_id' => '9b0665bf-f899-4b1e-bbdb-b2d7da0d880e',
                        'consult_date' => $row['CONSULTATION DATE'],
                        'consult_done' => 1,
                        'pt_group' => 'cn'
                    ]);

                    $notes = $consult->consultNotes()->create([
                        'facility_code' => 'DOH000000000048882',
                        'user_id' => '9b0662cd-29d5-401d-81da-118bdefacb3a',
                        'patient_id' => $patient->id,
                        'complaint' => $row['COMPLAINT NOTES'],
                        'history' => $row['HISTORY NOTES'],
                        'general_survey_code' => $row['GENERAL SURVEY'],
                    ]);

                    $complaint = $notes->complaints()->create([
                        'facility_code' => 'DOH000000000048882',
                        'user_id' => '9b0662cd-29d5-401d-81da-118bdefacb3a',
                        'consult_id' => $consult->id,
                        'patient_id' => $patient->id,
                        'complaint_id' => $row['CHIEF COMPLAINT']
                    ]);

                    $management = $notes->management()->create([
                        'facility_code' => 'DOH000000000048882',
                        'user_id' => '9b0662cd-29d5-401d-81da-118bdefacb3a',
                        'patient_id' => $patient->id,
                        'management_code' => $row['MGMT/COUNSELLING'],
                    ]);

                    $finalDx = $notes->finaldx()->create([
                        'facility_code' => 'DOH000000000048882',
                        'user_id' => '9b0665bf-f899-4b1e-bbdb-b2d7da0d880e',
                        'icd10_code' => $row['FINAL DIAGNOSIS']
                    ]);

                    $physicalExams = ['ABDOMEN12', 'CHEST06', 'GENITOURINARY01', 'HEART05', 'NEURO06', 'RECTAL01', 'SKIN15'];
                    foreach ($physicalExams as $pe)
                        $notes->physicalExam()->create([
                            'facility_code' => 'DOH000000000048882',
                            'user_id' => '9b0665bf-f899-4b1e-bbdb-b2d7da0d880e',
                            'pe_id' => $pe
                        ]);

                    dd($finalDx);

                }
                dd('done');
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
}
