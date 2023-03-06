<?php

namespace App\Services\Konsulta;

use App\Models\V1\Libraries\LibMedicalHistory;
use App\Models\V1\Libraries\LibSuffixName;
use App\Models\V1\Patient\Patient;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class KonsultaMigrationService
{
    public function saveProfile(Collection $collection)
    {
        //return $collection;
        return $collection->map(function ($value) {
            return collect($value->ENLISTMENTS)->map(function ($enlistment) use($value){
                if(is_array($enlistment)){
                    return collect($enlistment)->map(function($enlistment) use($value){
                        return $this->saveFirstPatientEncounter($enlistment, $value);
                    });
                } else {
                    return $this->saveFirstPatientEncounter($enlistment, $value);
                }
            });
        });
    }

    public function getSuffixName($suffix)
    {
        return LibSuffixName::query()
            ->where('code', 'CONTAINS', $suffix)
            ->first();
    }

    public function getMedicalHistory($konsultaId)
    {
        return LibMedicalHistory::query()
            ->where('konsulta_history_id', $konsultaId)
            ->first();
    }

    /**
     * @param $enlistment
     * @param $value
     * @param $profile
     * @param $patient
     * @return mixed
     */
    public function saveFirstPatientEncounter($enlistment, $value): mixed
    {
        $patient = Patient::updateOrCreate(['case_number' => $enlistment->pHciCaseNo], [
            'last_name' => $enlistment->pPatientLname,
            'first_name' => $enlistment->pPatientFname,
            'middle_name' => $enlistment->pPatientMname,
            'suffix_name' => $this->getSuffixName($enlistment->pPatientExtname) ?? "NA",
            'gender' => $enlistment->pPatientSex,
            'birthdate' => $enlistment->pPatientDob,
            'mobile_number' => $enlistment->pPatientMobileNo,
            'consent_flag' => true,
        ]);



        if(is_array($value->PROFILING->PROFILE)){
            collect($value->PROFILING)->map(function($profiling) use($patient, $enlistment, $value){
                $profile = collect($profiling)->where('pHciCaseNo', $patient->case_number)->first();
                $this->saveEnlistment($patient, $enlistment, $value, collect($profiling)->where('pHciCaseNo', $patient->case_number)->first());
                $this->saveMedHistory($profile, $patient, 'MEDHISTS', 'MHSPECIFICS');
                $this->saveMedHistory($profile, $patient, 'FAMHISTS', 'FHSPECIFICS');
            });
        } else{
            $profile = collect($value->PROFILING)->where('pHciCaseNo', $patient->case_number)->first();
            $this->saveEnlistment($patient, $enlistment, $value, collect($value->PROFILING)->where('pHciCaseNo', $patient->case_number)->first());
            $this->saveMedHistory($profile, $patient, 'MEDHISTS', 'MHSPECIFICS');
            $this->saveMedHistory($profile, $patient, 'FAMHISTS', 'FHSPECIFICS');
        }

        return $patient;
    }

    /**
     * @param mixed $profile
     * @param $patient
     */
    public function saveMedHistory(mixed $profile, $patient, $dataGroup, $dataGroupSpecific)
    {
        collect($profile->$dataGroup)->map(function ($history) use ($patient, $profile, $dataGroup, $dataGroupSpecific) {
            $category = 1;
            if($dataGroup != 'MEDHISTS'){
                $category = 2;
            }
            if (is_array($history)) {
                collect($history)->map(function ($history) use ($patient, $profile, $dataGroup, $dataGroupSpecific, $category) {
                    //$group = Str::singular($dataGroup);
                    $specific = Str::singular($dataGroupSpecific);
                    $remarks = collect($profile->$dataGroupSpecific->$specific)->where('pMdiseaseCode', $history->pMdiseaseCode)->first();
                    $patient->pastPatientHistory()->updateOrCreate(['patient_id' => $patient->id, 'medical_history_id' => $this->getMedicalHistory($history->pMdiseaseCode)->id, 'category' => $category], ['medical_history_id' => $this->getMedicalHistory($history->pMdiseaseCode)->id, 'category' => $category, 'remarks' => $remarks->pSpecificDesc?? ""]);
                });
            } else {
                $remarks = collect($profile->$dataGroupSpecific)->where('pMdiseaseCode', $history->pMdiseaseCode)->first();
                $patient->pastPatientHistory()->updateOrCreate(['patient_id' => $patient->id, 'medical_history_id' => $this->getMedicalHistory($history->pMdiseaseCode)->id, 'category' => $category], ['medical_history_id' => $this->getMedicalHistory($history->pMdiseaseCode)->id, 'category' => $category, 'remarks' => $remarks->pSpecificDesc?? ""]);
            }
        });
    }

    public function saveEnlistment($patient, $enlistment, $value, $profile)
    {
        $patient->philhealth()->updateOrCreate(
            [
                'philhealth_id' => $enlistment->pPatientPin,
                'transaction_number' => Str::replaceFirst('E', '', $enlistment->pHciTransNo),
                'effectivity_year' => $enlistment->pEffYear,
            ],
            [
                'transaction_number' => Str::replaceFirst('E', '', $enlistment->pHciTransNo),
                'transmittal_number' => $value->pHciTransmittalNumber,
                'philhealth_id' => $enlistment->pPatientPin,
                'enlistment_date' => $enlistment->pEnlistDate,
                'effectivity_year' => $enlistment->pEffYear,
                'enlistment_status_id' => 1,
                'package_type_id' => $enlistment->pPackageType,
                'membership_type_id' => $enlistment->pPatientType,
                'membership_category_id' => 18,
                'member_pin' => $enlistment->pPatientType == 'DD' ? $enlistment->pMemPin : null,
                'member_last_name' => $enlistment->pPatientType == 'DD' ? $enlistment->pMemLname : null,
                'member_first_name' => $enlistment->pPatientType == 'DD' ? $enlistment->pMemFname : null,
                'member_middle_name' => $enlistment->pPatientType == 'DD' ? $enlistment->pMemFname : null,
                'member_suffix_name' => $enlistment->pPatientType == 'DD' ? $this->getSuffixName($enlistment->pPatientExtname) ?? "NA" : null,
                'member_birthdate' => $enlistment->pPatientType == 'DD' ? $enlistment->pMemDob : null,
                'member_gender' => $enlistment->pPatientType == 'DD' ? $enlistment->pPatientSex : null,
                'authorization_transaction_code' => $profile->pATC,
                'walkedin_status' => $profile->pIsWalkedIn == 'N' ? 0 : 1,
        ]);
    }

}
