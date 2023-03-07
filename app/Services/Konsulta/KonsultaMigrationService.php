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
            return collect($value->PROFILING)->map(function($profiling) use($patient, $enlistment, $value){
                $profile = collect($profiling)->where('pHciCaseNo', $patient->case_number)->first();
                $this->saveEnlistment($patient, $enlistment, $value, $profile);
                $this->saveMedHistory($profile, $patient, 'MEDHISTS', 'MHSPECIFICS');
                $this->saveMedHistory($profile, $patient, 'FAMHISTS', 'FHSPECIFICS');
                $this->saveSurgicalHistory($profile, $patient);
                return $this->saveImmunization($profile, $patient);

            });
        } else{
            $profile = collect($value->PROFILING)->where('pHciCaseNo', $patient->case_number)->first();
            $this->saveEnlistment($patient, $enlistment, $value, $profile);
            $this->saveMedHistory($profile, $patient, 'MEDHISTS', 'MHSPECIFICS');
            $this->saveMedHistory($profile, $patient, 'FAMHISTS', 'FHSPECIFICS');
            $this->saveSurgicalHistory($profile, $patient);
            return $this->saveImmunization($profile, $patient);
        }

        return $patient;
    }

    /**
     * @param mixed $profile
     * @param $patient
     * @param $dataGroup
     * @param $dataGroupSpecific
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

    /**
     * @param $patient
     * @param $enlistment
     * @param $value
     * @param $profile
     * @return void
     */
    public function saveEnlistment($patient, $enlistment, $value, $profile): void
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

        $patient->update(['blood_type_code' => $profile->BLOODTYPE->pBloodType?? "NA"]);

        $socialHistory = $profile->SOCHIST;
        if(!empty($socialHistory->pIsSmoker)){
            $data = [
                'smoking' => $socialHistory->pIsSmoker,
                'alcohol' => $socialHistory->pIsAdrinker,
                'illicit_drugs' => $socialHistory->pIllDrugUser,
                'sexually_active' => $socialHistory->pIsSexuallyActive,
            ];
            !empty($socialHistory->pNoCigpk) ? $data['pack_per_year'] = $socialHistory->pNoCigpk : null;
            !empty($socialHistory->pNoBottles) ? $data['bottles_per_day'] = $socialHistory->pNoBottles : null;
            $patient->socialHistory()->updateOrCreate(['patient_id' => $patient->id], $data);
        }
        $menstrualHistory = $profile->MENSHIST;
        if($menstrualHistory->pIsApplicable == 'Y'){
            $data = [
                'menarche' => $menstrualHistory->pMenarchePeriod,
                'lmp' => $menstrualHistory->pLastMensPeriod,
                'method' => $menstrualHistory->pBirthCtrlMethod,
                'menopause' => $menstrualHistory->pIsMenopause == 'Y' ? 1 : 0,
            ];
            if(!empty($menstrualHistory->pPeriodDuration)){
                $data['period_duration'] = $menstrualHistory->pPeriodDuration;
            }
            if(!empty($menstrualHistory->pMensInterval)){
                $data['cycle'] = $menstrualHistory->pMensInterval;
            }
            if(!empty($menstrualHistory->pPadsPerDay)){
                $data['pads_per_day'] = $menstrualHistory->pPadsPerDay;
            }
            if(!empty($menstrualHistory->pOnsetSexIc)){
                $data['onset_sexual_intercourse'] = $menstrualHistory->pOnsetSexIc;
            }
            if(!empty($menstrualHistory->pMenopauseAge)){
                $data['menopause_age'] = $menstrualHistory->pMenopauseAge;
            }
            $patient->menstrualHistory()->updateOrCreate(['patient_id' => $patient->id], $data);
        }

        $pregnancyHistory = $profile->PREGHIST;
        if($pregnancyHistory->pIsApplicable == 'Y'){
            $data = [
                'gravidity' => $pregnancyHistory->pPregCnt,
                'parity' => $pregnancyHistory->pDeliveryCnt,
                'delivery_type' => $pregnancyHistory->pDeliveryTyp,
                'full_term' => $pregnancyHistory->pFullTermCnt,
                'preterm' => $pregnancyHistory->pPrematureCnt,
                'abortion' => $pregnancyHistory->pAbortionCnt,
                'livebirths' => $pregnancyHistory->pLivChildrenCnt,
                'induced_hypertension' => $pregnancyHistory->pWPregIndhyp,
                'with_family_planning' => $pregnancyHistory->pWFamPlan,
            ];
            $patient->pregnancyHistory()->updateOrCreate(['patient_id' => $patient->id], $data);
        }

        $patientVitals = $profile->PEPERT;
        $data = [
            'vitals_date' => $profile->pProfDate
        ];
        !empty($patientVitals->pSystolic) ? $data['bp_systolic'] = $patientVitals->pSystolic : null;
        !empty($patientVitals->pDiastolic) ? $data['bp_diastolic'] = $patientVitals->pDiastolic : null;
        !empty($patientVitals->pHr) ? $data['patient_heart_rate'] = $patientVitals->pHr : null;
        !empty($patientVitals->pRr) ? $data['patient_respiratory_rate'] = $patientVitals->pRr : null;
        !empty($patientVitals->pTemp) ? $data['patient_temp'] = $patientVitals->pTemp : null;
        !empty($patientVitals->pHeight) ? $data['patient_height'] = $patientVitals->pHeight : null;
        !empty($patientVitals->pWeight) ? $data['patient_weight'] = $patientVitals->pWeight : null;
        !empty($patientVitals->pBMI) ? $data['patient_bmi'] = $patientVitals->pBMI : null;
        !empty($patientVitals->pLeftVision) ? $data['patient_left_vision_acuity'] = $patientVitals->pLeftVision : null;
        !empty($patientVitals->pRightVision) ? $data['patient_right_vision_acuity'] = $patientVitals->pRightVision : null;
        !empty($patientVitals->pHeadCirc) ? $data['patient_head_circumference'] = $patientVitals->pHeadCirc : null;
        !empty($patientVitals->pSkinfoldThickness) ? $data['patient_skinfold_thickness'] = $patientVitals->pSkinfoldThickness : null;
        !empty($patientVitals->pWaist) ? $data['patient_waist'] = $patientVitals->pWaist : null;
        !empty($patientVitals->pHip) ? $data['patient_hip'] = $patientVitals->pHip : null;
        !empty($patientVitals->pLimbs) ? $data['patient_limbs'] = $patientVitals->pLimbs : null;
        !empty($patientVitals->pMidUpperArmCirc) ? $data['patient_muac'] = $patientVitals->pMidUpperArmCirc : null;

        $patient->patientVitals()->updateOrCreate(['patient_id' => $patient->id], $data);

    }

    /**
     * @param mixed $profile
     * @param $patient
     */
    public function saveSurgicalHistory(mixed $profile, $patient)
    {
        collect($profile->SURGHISTS)->map(function ($history) use ($patient, $profile) {
            if (is_array($history)) {
                collect($history)->map(function ($history) use ($patient, $profile) {
                    if(!empty($history->pSurgDesc)){
                        $patient->surgicalHistory()->updateOrCreate(
                            [
                                'operation' => $history->pSurgDesc,
                                'operation_date' => $history->pSurgDate,
                            ]
                        );
                    }
                });
            } else {
                if(!empty($history->pSurgDesc)){
                    $patient->surgicalHistory()->updateOrCreate(
                        [
                            'operation' => $history->pSurgDesc,
                            'operation_date' => $history->pSurgDate,
                        ]
                    );
                }
            }
        });
    }

    /**
     * @param mixed $profile
     * @param $patient
     */
    public function saveImmunization(mixed $profile, $patient)
    {
        return collect($profile->IMMUNIZATIONS)->map(function ($immunization) use ($patient, $profile) {
            if (is_array($immunization)) {
                return collect($immunization)->map(function ($immunization) use ($patient, $profile) {
                    //if(!empty($immunization->pChildImmcode) && $immunization->pChildImmcode != '999'){
                    $this->immunization($immunization, $patient);

                    //}
                });
            } else {
                $this->immunization($immunization, $patient);
            }
        });
    }

    /**
     * @param $immunization
     * @param $patient
     * @return void
     */
    public function immunization($immunization, $patient): void
    {
        $vaccine_id = '';
        if (!empty($immunization->pChildImmcode) && $immunization->pChildImmcode != '999') {
            switch ($immunization->pChildImmcode) {
                case 'C01':
                    $vaccine_id = 'BCG';
                    break;
                case 'C02':
                case 'C03':
                case 'C04':
                    $vaccine_id = 'OPV';
                    break;
                case 'C05':
                case 'C06':
                case 'C07':
                    $vaccine_id = 'DPT';
                    break;
                case 'C08':
                    $vaccine_id = 'MCV';
                    break;
                case 'C09':
                case 'C10':
                case 'C11':
                    $vaccine_id = 'HEPB';
                    break;
                case 'C12':
                    $vaccine_id = 'HEPA';
                    break;
                case 'C13':
                    $vaccine_id = 'CPV';
                    break;
                default:
                    break;
            }
        }
        if (!empty($immunization->pYoungwImmcode) && $immunization->pYoungwImmcode != '999') {
            switch ($immunization->pYoungwImmcode) {
                case 'Y01':
                    $vaccine_id = 'HPV';
                    break;
                case 'Y02':
                    $vaccine_id = 'MRGR';
                    break;
                default:
                    break;
            }
        }
        if (!empty($immunization->pPregwImmcode) && $immunization->pPregwImmcode != '999') {
            switch ($immunization->pPregwImmcode) {
                case 'P01':
                    $vaccine_id = 'TD';
                    break;
                default:
                    break;
            }
        }
        if (!empty($immunization->pElderlyImmcode) && $immunization->pElderlyImmcode != '999') {
            switch ($immunization->pElderlyImmcode) {
                case 'E01':
                    $vaccine_id = 'PPV';
                    break;
                case 'E02':
                    $vaccine_id = 'FLU';
                    break;
                default:
                    break;
            }
        }
        if (!empty($vaccine_id)) {
            $patient->patientvaccine()->create([
                'vaccine_id' => $vaccine_id,
                'status_id' => 1
            ]);
        }
    }

}
