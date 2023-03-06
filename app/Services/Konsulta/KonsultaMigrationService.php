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
            collect($value->PROFILING)->map(function($profiling) use($patient){
                $profile = collect($profiling)->where('pHciCaseNo', $patient->case_number)->first();
                $this->getMedHistory($profile, $patient, 'MEDHISTS', 'MHSPECIFICS');
                $this->getMedHistory($profile, $patient, 'FAMHISTS', 'FHSPECIFICS');
            });
        } else{
            $profile = collect($value->PROFILING)->where('pHciCaseNo', $patient->case_number)->first();
            $this->getMedHistory($profile, $patient, 'MEDHISTS', 'MHSPECIFICS');
            $this->getMedHistory($profile, $patient, 'FAMHISTS', 'FHSPECIFICS');
        }

        return $patient;
    }

    /**
     * @param mixed $profile
     * @param $patient
     */
    public function getMedHistory(mixed $profile, $patient, $dataGroup, $dataGroupSpecific)
    {
        collect($profile->$dataGroup)->map(function ($history) use ($patient, $profile, $dataGroup, $dataGroupSpecific) {
            $category = 1;
            if($dataGroup != 'MEDHISTS'){
                $category = 2;
            }
            if (is_array($history)) {
                collect($history)->map(function ($history) use ($patient, $profile, $dataGroup, $dataGroupSpecific, $category) {
                    $group = Str::singular($dataGroup);
                    $specific = Str::singular($dataGroupSpecific);
                    $remarks = collect($profile->$dataGroupSpecific->$specific)->where('pMdiseaseCode', $history->pMdiseaseCode)->first();
                    $patient->patientHistory()->updateOrCreate(['medical_history_id' => $this->getMedicalHistory($history->pMdiseaseCode)->id, 'category' => $category, 'remarks' => $remarks->pSpecificDesc?? ""]);
                });
            } else {
                $remarks = collect($profile->$dataGroupSpecific)->where('pMdiseaseCode', $history->pMdiseaseCode)->first();
                $patient->patientHistory()->updateOrCreate(['medical_history_id' => $this->getMedicalHistory($history->pMdiseaseCode)->id, 'category' => $category, 'remarks' => $remarks->pSpecificDesc?? ""]);
            }
        });
    }

}
