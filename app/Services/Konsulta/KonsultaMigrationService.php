<?php

namespace App\Services\Konsulta;

use App\Models\V1\Consultation\Consult;
use App\Models\V1\Laboratory\ConsultLaboratory;
use App\Models\V1\Libraries\LibComplaint;
use App\Models\V1\Libraries\LibLaboratory;
use App\Models\V1\Libraries\LibMedicalHistory;
use App\Models\V1\Libraries\LibPe;
use App\Models\V1\Libraries\LibSuffixName;
use App\Models\V1\Patient\Patient;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class KonsultaMigrationService
{
    public function saveProfile(Collection $collection)
    {
        //return $collection;
         $collection->map(function ($value) {
             collect($value->ENLISTMENTS)->map(function ($enlistment) use($value){
                if(is_array($enlistment)){
                     collect($enlistment)->map(function($enlistment) use($value){
                        $this->saveFirstPatientEncounter($enlistment, $value);
                    });
                } else {
                     $this->saveFirstPatientEncounter($enlistment, $value);
                }
            });
        });
        return $collection;
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
                $this->saveImmunization($profile, $patient);
                $this->savePhysicalExam($profile, $patient);
                $this->saveDiagnostic($value, $patient, $profile);
                return $this->saveConsultation($value, $profile, $patient);

            });
        } else{
            $profile = collect($value->PROFILING)->where('pHciCaseNo', $patient->case_number)->first();
            $this->saveEnlistment($patient, $enlistment, $value, $profile);
            $this->saveMedHistory($profile, $patient, 'MEDHISTS', 'MHSPECIFICS');
            $this->saveMedHistory($profile, $patient, 'FAMHISTS', 'FHSPECIFICS');
            $this->saveSurgicalHistory($profile, $patient);
            $this->saveImmunization($profile, $patient);
            $this->savePhysicalExam($profile, $patient);
            $this->saveDiagnostic($value, $patient, $profile);
            return $this->saveConsultation($value, $profile, $patient);
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
                    if(!empty($history->pMdiseaseCode)) {
                        $specific = Str::singular($dataGroupSpecific);
                        $remarks = collect($profile->$dataGroupSpecific->$specific)->where('pMdiseaseCode', $history->pMdiseaseCode)->first();
                        $patient->pastPatientHistory()->updateOrCreate(['patient_id' => $patient->id, 'medical_history_id' => $this->getMedicalHistory($history->pMdiseaseCode)->id, 'category' => $category], ['medical_history_id' => $this->getMedicalHistory($history->pMdiseaseCode)->id, 'category' => $category, 'remarks' => $remarks->pSpecificDesc ?? ""]);
                    }
                });
            } else {
                if(!empty($history->pMdiseaseCode)) {
                    $remarks = collect($profile->$dataGroupSpecific)->where('pMdiseaseCode', $history->pMdiseaseCode)->first();
                    $patient->pastPatientHistory()->updateOrCreate(['patient_id' => $patient->id, 'medical_history_id' => $this->getMedicalHistory($history->pMdiseaseCode)->id, 'category' => $category], ['medical_history_id' => $this->getMedicalHistory($history->pMdiseaseCode)->id, 'category' => $category, 'remarks' => $remarks->pSpecificDesc ?? ""]);
                }
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

        if(isset($profile->PEGENSURVEY) && !empty($profile->PEGENSURVEY->pGenSurveyId)){
            $consult = Consult::updateOrCreate([
                'patient_id' => $patient->id,
                'consult_date' => $profile->pProfDate,
                'pt_group' => 'cn',
                'consult_done' => 1,
            ]);
            $notes = $consult->consultNotes()->updateOrCreate(['consult_id' => $consult->id, 'patient_id' => $consult->patient_id],
                [
                    'complaint' => 'Health Screening and Assessment',
                    'history' => 'Health Screening and Assessment',
                    'general_survey_code' => $profile->PEGENSURVEY->pGenSurveyId,
                    'general_survey_remarks' => $profile->PEGENSURVEY->pGenSurveyRem
                ]
            );
            $complaint = $notes->complaints()->updateOrCreate(['notes_id' => $notes->id, 'consult_id' => $consult->id, 'patient_id' => $patient->id, 'complaint_id' => 'OTHERS']);
        }

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

    /**
     * @param mixed $profile
     * @param $patient
     */
    public function savePhysicalExam(mixed $profile, $patient)
    {
        if(isset($profile->PEMISCS)){
            return collect($profile->PEMISCS)->map(function ($pe) use ($patient, $profile) {
                $consult = Consult::updateOrCreate([
                    'patient_id' => $patient->id,
                    'consult_date' => $profile->pProfDate,
                    'pt_group' => 'cn',
                    'consult_done' => 1,
                ]);
                //$notes = $consult->consultNotes()->updateOrCreate(['consult_id' => $consult->id, 'patient_id' => $consult->patient_id]);
                $notes = $consult->consultNotes()->updateOrCreate(['consult_id' => $consult->id, 'patient_id' => $consult->patient_id],
                    [
                        'complaint' => 'Health Screening and Assessment',
                        'history' => 'Health Screening and Assessment',
                    ]
                );
                $complaint = $notes->complaints()->updateOrCreate(['notes_id' => $notes->id, 'consult_id' => $consult->id, 'patient_id' => $patient->id, 'complaint_id' => 'OTHERS']);
                if(!empty($profile->PESPECIFIC->pSkinRem) || !empty($profile->PESPECIFIC->pHeentRem)
                    || !empty($profile->PESPECIFIC->pChestRem) || !empty($profile->PESPECIFIC->pHeartRem)
                    || !empty($profile->PESPECIFIC->pAbdomenRem) || !empty($profile->PESPECIFIC->pNeuroRem)
                    || !empty($profile->PESPECIFIC->pRectalRem) || !empty($profile->PESPECIFIC->pGuRem)){
                    $notes->physicalExamRemarks()->updateOrCreate(['notes_id' => $notes->id, 'patient_id' => $patient->id],
                        [
                            'skin_remarks' => $profile->PESPECIFIC->pSkinRem,
                            'heent_remarks' => $profile->PESPECIFIC->pHeentRem,
                            'chest_remarks' => $profile->PESPECIFIC->pChestRem,
                            'heart_remarks' => $profile->PESPECIFIC->pHeartRem,
                            'abdomen_remarks' => $profile->PESPECIFIC->pAbdomenRem,
                            'neuro_remarks' => $profile->PESPECIFIC->pNeuroRem,
                            'rectal_remarks' => $profile->PESPECIFIC->pRectalRem,
                            'genitourinary_remarks' => $profile->PESPECIFIC->pGuRem,
                        ]
                    );
                }
                if (is_array($pe)) {
                    return collect($pe)->map(function ($pe) use ($patient, $profile, $notes) {
                        $this->physicalExam($pe, $notes);
                    });
                } else {
                    $this->physicalExam($pe, $notes);
                }
            });
        }
    }

    /**
     * @param $value
     * @return void
     */
    function saveDiagnostic($value, $patient, $profile)
    {
        if (isset($value->DIAGNOSTICEXAMRESULTS)) {
            //return $value->DIAGNOSTICEXAMRESULTS;
            //return collect($value->DIAGNOSTICEXAMRESULTS)->where('pHciCaseNo', $patient->case_number)->first();
            if (is_array($value->DIAGNOSTICEXAMRESULTS->DIAGNOSTICEXAMRESULT)) {
                $laboratory = collect($value->DIAGNOSTICEXAMRESULTS->DIAGNOSTICEXAMRESULT)->where('pHciCaseNo', $patient->case_number)
                    ->filter(function ($transaction) {
                        return str_starts_with(strtolower($transaction->pHciTransNo), 'p');
                    })->first();
            } else{
                $laboratory = collect($value->DIAGNOSTICEXAMRESULTS)->where('pHciCaseNo', $patient->case_number)
                    ->filter(function ($transaction) {
                        return str_starts_with(strtolower($transaction->pHciTransNo), 'p');
                    })->first();
            }
            return $this->saveLaboratory($laboratory, $value, $profile, $patient);
        }
    }

    /**
     * @param mixed $laboratory
     * @param $value
     * @param $profile
     * @param $patient
     * @return void
     */
    public function saveLaboratory(mixed $laboratory, $value, $profile, $patient)
    {
        if (isset($laboratory->FBSS)) {
            if (is_array($laboratory->FBSS)) {
                 collect($laboratory->FBSS)->map(function ($fbs) use ($value, $profile, $patient) {
                    $data = [
                        'request_date' => $profile->pProfDate,
                        'lab_code' => 'FBS',
                    ];
                    $lab = ConsultLaboratory::query()
                        ->updateOrCreate(['patient_id' => $patient->id, 'request_date' => $profile->pProfDate, 'lab_code' => 'FBS']);

                    $fbsData = [
                        'referral_facility' => $fbs->pReferralFacility,
                        'patient_id' => $patient->id,
                        'laboratory_date' => $fbs->pLabDate,
                        'glucose' => $fbs->pGlucoseMg,
                        'lab_status_code' => $fbs->pStatus,
                    ];
                    $lab->fbs()->updateOrCreate($fbsData);
                });
            } else {
                //return $laboratory->FBSS->FBS->pReferralFacility;
                $data = [
                    'request_date' => $profile->pProfDate,
                    'lab_code' => 'FBS',
                ];
                $lab = ConsultLaboratory::query()
                    ->updateOrCreate(['patient_id' => $patient->id, 'request_date' => $profile->pProfDate, 'lab_code' => 'FBS']);
                $fbsData = [
                    'referral_facility' => $laboratory->FBSS->FBS->pReferralFacility,
                    'patient_id' => $patient->id,
                    'laboratory_date' => $laboratory->FBSS->FBS->pLabDate,
                    'glucose' => $laboratory->FBSS->FBS->pGlucoseMg,
                    'lab_status_code' => $laboratory->FBSS->FBS->pStatus,
                ];
                $lab->fbs()->updateOrCreate($fbsData);
            }
        }
        if (isset($laboratory->RBSS)) {
            if (is_array($laboratory->RBSS)) {
                collect($laboratory->RBSS)->map(function ($rbs) use ($value, $profile, $patient) {
                    $data = [
                        'request_date' => $profile->pProfDate,
                        'lab_code' => 'RBS',
                    ];
                    $lab = ConsultLaboratory::query()
                        ->updateOrCreate(['patient_id' => $patient->id, 'request_date' => $profile->pProfDate, 'lab_code' => 'RBS']);

                    $rbsData = [
                        'referral_facility' => $rbs->pReferralFacility,
                        'patient_id' => $patient->id,
                        'laboratory_date' => $rbs->pLabDate,
                        'glucose' => $rbs->pGlucoseMg,
                        'lab_status_code' => $rbs->pStatus,
                    ];
                    $lab->rbs()->updateOrCreate($rbsData);
                });
            } else {
                //return $laboratory->FBSS->FBS->pReferralFacility;
                $data = [
                    'request_date' => $profile->pProfDate,
                    'lab_code' => 'RBS',
                ];
                $lab = ConsultLaboratory::query()
                    ->updateOrCreate(['patient_id' => $patient->id, 'request_date' => $profile->pProfDate, 'lab_code' => 'RBS']);
                $rbsData = [
                    'referral_facility' => $laboratory->RBSS->RBS->pReferralFacility,
                    'patient_id' => $patient->id,
                    'laboratory_date' => $laboratory->RBSS->RBS->pLabDate,
                    'glucose' => $laboratory->RBSS->RBS->pGlucoseMg,
                    'lab_status_code' => $laboratory->RBSS->RBS->pStatus,
                ];
                $lab->rbs()->updateOrCreate($rbsData);
            }
        }
    }

    /**
     * @param $pe
     * @param $notes
     * @return void
     */
    public function physicalExam($pe, $notes): void
    {
        if (!empty($pe->pSkinId)) {
            $lib = LibPe::query()
                ->where('konsulta_pe_id', $pe->pSkinId)
                ->where('category_id', 'SKIN')
                ->first();
            $notes->physicalExam()->updateOrCreate(['notes_id' => $notes->id, 'pe_id' => $lib->pe_id]);
        }
        if (!empty($pe->pHeentId)) {
            $lib = LibPe::query()
                ->where('konsulta_pe_id', $pe->pHeentId)
                ->where('category_id', 'HEENT')
                ->first();
            $notes->physicalExam()->updateOrCreate(['notes_id' => $notes->id, 'pe_id' => $lib->pe_id]);
        }
        if (!empty($pe->pChestId)) {
            $lib = LibPe::query()
                ->where('konsulta_pe_id', $pe->pChestId)
                ->where('category_id', 'CHEST')
                ->first();
            $notes->physicalExam()->updateOrCreate(['notes_id' => $notes->id, 'pe_id' => $lib->pe_id]);
        }
        if (!empty($pe->pHeartId)) {
            $lib = LibPe::query()
                ->where('konsulta_pe_id', $pe->pHeartId)
                ->where('category_id', 'HEART')
                ->first();
            $notes->physicalExam()->updateOrCreate(['notes_id' => $notes->id, 'pe_id' => $lib->pe_id]);
        }
        if (!empty($pe->pAbdomenId)) {
            $lib = LibPe::query()
                ->where('konsulta_pe_id', $pe->pAbdomenId)
                ->where('category_id', 'ABDOMEN')
                ->first();
            $notes->physicalExam()->updateOrCreate(['notes_id' => $notes->id, 'pe_id' => $lib->pe_id]);
        }
        if (!empty($pe->pNeuroId)) {
            $lib = LibPe::query()
                ->where('konsulta_pe_id', $pe->pNeuroId)
                ->where('category_id', 'NEURO')
                ->first();
            $notes->physicalExam()->updateOrCreate(['notes_id' => $notes->id, 'pe_id' => $lib->pe_id]);
        }
        if (!empty($pe->pRectalId)) {
            $lib = LibPe::query()
                ->where('konsulta_pe_id', $pe->pRectalId)
                ->where('category_id', 'RECTAL')
                ->first();
            $notes->physicalExam()->updateOrCreate(['notes_id' => $notes->id, 'pe_id' => $lib->pe_id]);
        }
        if (!empty($pe->pGuId)) {
            $lib = LibPe::query()
                ->where('konsulta_pe_id', $pe->pGuId)
                ->where('category_id', 'GENITOURINARY')
                ->first();
            $notes->physicalExam()->updateOrCreate(['notes_id' => $notes->id, 'pe_id' => $lib->pe_id]);
        }
    }

    /**
     * @param $value
     * @param $profile
     * @param $patient
     */
    public function saveConsultation($value, $profile, $patient)
    {
        if(is_array($value->SOAPS->SOAP)) {
            $soap = collect($value->SOAPS->SOAP)->where('pHciCaseNo', $patient->case_number)->first();
            return $this->saveSubjective($soap, $patient, $value);
        } else{
            $soap = collect($value->SOAPS)->where('pHciCaseNo', $patient->case_number)->first();
            return $this->saveSubjective($soap, $patient, $value);
        }
    }

    /**
     * @param mixed $soap
     * @param $patient
     * @param $value
     * @return void
     */
    public function saveSubjective(mixed $soap, $patient, $collection)
    {
        if ($soap) {
            $consult = Consult::updateOrCreate([
                'patient_id' => $patient->id,
                'consult_date' => $soap->pSoapDate,
                'pt_group' => 'cn',
                'consult_done' => 1,
            ], [
                'transaction_number' => Str::replaceFirst('S', '', $soap->pHciTransNo),
                'authorization_transaction_code' => $soap->pATC,
                'walkedin_status' => $soap->pIsWalkedIn == 'Y' ? 1 : 0
            ]);
            $notes = $consult->consultNotes()->updateOrCreate(['consult_id' => $consult->id, 'patient_id' => $consult->patient_id]);

            if (isset($soap->SUBJECTIVE)) {
                $notes = $consult->consultNotes()->updateOrCreate(['consult_id' => $consult->id, 'patient_id' => $consult->patient_id], [
                    'history' => $soap->SUBJECTIVE->pIllnessHistory,
                    'complaint' => $soap->SUBJECTIVE->pOtherComplaint
                ]);
                //$konsultaComplaints = explode(';', $soap->SUBJECTIVE->pSignsSymptoms);
                $konsultaComplaints = preg_split("/[,;]/", $soap->SUBJECTIVE->pSignsSymptoms);
                foreach ($konsultaComplaints as $value) {
                    $complaintId = LibComplaint::query()
                        ->when($value == '38', fn($query) => $query->where('complaint_desc', 'LIKE', '%' . $soap->SUBJECTIVE->pPainSite . '%'))
                        ->when($value != '38', fn($query) => $query->where('konsulta_complaint_id', $value))
                        ->first();
                    $complaint = $notes->complaints()->updateOrCreate(['notes_id' => $notes->id, 'consult_id' => $consult->id, 'patient_id' => $patient->id, 'complaint_id' => $complaintId->complaint_id]);
                }
            }

            if (isset($soap->PEMISCS)) {
                //return $soap->PEMISCS;
                if (is_array($soap->PEMISCS->PEMISC)) {
                    collect($soap->PEMISCS->PEMISC)->map(function ($pe) use ($notes) {
                        $this->physicalExam($pe, $notes);
                    });
                } else {
                    $this->physicalExam($soap->PEMISCS->PEMISC, $notes);
                }
                if(!empty($soap->PESPECIFIC->pSkinRem) || !empty($soap->PESPECIFIC->pHeentRem)
                    || !empty($soap->PESPECIFIC->pChestRem) || !empty($soap->PESPECIFIC->pHeartRem)
                    || !empty($soap->PESPECIFIC->pAbdomenRem) || !empty($soap->PESPECIFIC->pNeuroRem)
                    || !empty($soap->PESPECIFIC->pRectalRem) || !empty($soap->PESPECIFIC->pGuRem)){
                    $notes->physicalExamRemarks()->updateOrCreate(['notes_id' => $notes->id, 'patient_id' => $patient->id],
                        [
                            'skin_remarks' => $soap->PESPECIFIC->pSkinRem,
                            'heent_remarks' => $soap->PESPECIFIC->pHeentRem,
                            'chest_remarks' => $soap->PESPECIFIC->pChestRem,
                            'heart_remarks' => $soap->PESPECIFIC->pHeartRem,
                            'abdomen_remarks' => $soap->PESPECIFIC->pAbdomenRem,
                            'neuro_remarks' => $soap->PESPECIFIC->pNeuroRem,
                            'rectal_remarks' => $soap->PESPECIFIC->pRectalRem,
                            'genitourinary_remarks' => $soap->PESPECIFIC->pGuRem,
                        ]
                    );
                }
            }

            if(isset($soap->ICDS)){
                if(is_array($soap->ICDS->ICD)){
                    collect($soap->ICDS->ICD)->map(function ($icd) use ($notes) {
                        $notes->finaldx()->updateOrCreate(['notes_id' => $notes->id, 'icd10_code' => $icd->pIcdCode]);
                    });
                } else{
                    $notes->finaldx()->updateOrCreate(['notes_id' => $notes->id, 'icd10_code' => $soap->ICDS->ICD->pIcdCode]);
                }
            }

            if(isset($soap->MANAGEMENTS)){
                if(is_array($soap->MANAGEMENTS->MANAGEMENT)){
                    collect($soap->MANAGEMENTS->MANAGEMENT)->map(function ($management) use ($notes, $patient) {
                        $notes->management()->updateOrCreate(['notes_id' => $notes->id, 'patient_id' => $patient->id],[
                            'management_code' => $management->pManagementId,
                            'remarks' => $management->pOthRemarks
                        ]);
                    });
                } else{
                    $notes->management()->updateOrCreate(['notes_id' => $notes->id, 'patient_id' => $patient->id],[
                        'management_code' => $soap->MANAGEMENTS->MANAGEMENT->pManagementId,
                        'remarks' => $soap->MANAGEMENTS->MANAGEMENT->pOthRemarks
                    ]);
                }
            }

            if(isset($soap->ADVICE)){
                $notes->updateOrCreate(['consult_id' => $consult->id, 'patient_id' => $consult->patient_id],[
                    'plan' => $soap->ADVICE->pRemarks
                ]);
            }

            if(isset($soap->DIAGNOSTICS)){
                if(is_array($soap->DIAGNOSTICS->DIAGNOSTIC)){
                    return collect($soap->DIAGNOSTICS->DIAGNOSTIC)->map(function ($diagnostic) use ($consult, $patient, $soap, $collection) {
                        $labId = LibLaboratory::query()
                            ->where('konsulta_lab_id', $diagnostic->pDiagnosticId)
                            ->first();
                        if(!empty($labId)){
                            $consultLab = ConsultLaboratory::query()->updateOrCreate(['patient_id' => $patient->id, 'request_date' => $soap->pSoapDate, 'lab_code' => $labId->code], [
                                'consult_id' => $consult->id,
                                'recommendation_code' => $diagnostic->pIsPhysicianRecommendation,
                                'request_status_code' => $diagnostic->pPatientRemarks
                            ]);
                            if($diagnostic->pPatientRemarks == 'RQ'){
                                $this->saveSoapDiagnostic($collection, $patient, $soap->pHciTransNo, $consultLab);
                            }

                        }
                    });
                } else{
                    $labId = LibLaboratory::query()
                        ->where('konsulta_lab_id', $soap->DIAGNOSTICS->DIAGNOSTIC->pDiagnosticId)
                        ->first();
                    if(!empty($labId)){
                        $consultLab = ConsultLaboratory::query()->updateOrCreate(['patient_id' => $patient->id, 'request_date' => $soap->pSoapDate, 'lab_code' => $labId->code], [
                            'consult_id' => $consult->id,
                            'recommendation_code' => $soap->DIAGNOSTICS->DIAGNOSTIC->pIsPhysicianRecommendation,
                            'request_status_code' => $soap->DIAGNOSTICS->DIAGNOSTIC->pPatientRemarks
                        ]);
                        if($soap->DIAGNOSTICS->DIAGNOSTIC->pPatientRemarks == 'RQ'){
                            $this->saveSoapDiagnostic($collection, $patient, $soap->pHciTransNo, $consultLab);
                        }
                    }
                }
            }
        }
    }

    /**
     * @param $value
     * @return void
     */
    function saveSoapDiagnostic($value, $patient, $transaction, $consultLaboratory)
    {
        if (isset($value->DIAGNOSTICEXAMRESULTS)) {
            //return $value->DIAGNOSTICEXAMRESULTS;
            //return collect($value->DIAGNOSTICEXAMRESULTS)->where('pHciCaseNo', $patient->case_number)->first();
            if (is_array($value->DIAGNOSTICEXAMRESULTS->DIAGNOSTICEXAMRESULT)) {
                $laboratory = collect($value->DIAGNOSTICEXAMRESULTS->DIAGNOSTICEXAMRESULT)
                    ->where('pHciCaseNo', $patient->case_number)
                    ->where('pHciTransNo', $transaction)
                    ->filter(function ($transaction) {
                        return str_starts_with(strtolower($transaction->pHciTransNo), 's');
                    })->first();
                $this->saveSoapLaboratory($laboratory, $consultLaboratory, $patient);
            } else{
                $laboratory = collect($value->DIAGNOSTICEXAMRESULTS)->where('pHciCaseNo', $patient->case_number)
                    ->filter(function ($transaction) {
                        return str_starts_with(strtolower($transaction->pHciTransNo), 's');
                    })->first();

                $this->saveSoapLaboratory($laboratory, $consultLaboratory, $patient);
            }
            //return $this->saveLaboratory($laboratory, $value, $profile, $patient);
        }
    }

    /**
     * @param mixed $laboratory
     * @param $consultLaboratory
     * @param $patient
     * @return void
     */
    public function saveSoapLaboratory(mixed $laboratory, $consultLaboratory, $patient): void
    {
        if (isset($laboratory->CBCS) && $consultLaboratory->lab_code == 'CBC') {
            if (is_array($laboratory->CBCS->CBC)) {
                collect($laboratory->CBCS->CBC)->map(function ($cbc) use ($consultLaboratory, $patient) {
                    $cbcData = [
                        'referral_facility' => $cbc->pReferralFacility,
                        'laboratory_date' => $cbc->pLabDate,
                        'hematocrit' => $cbc->pHematocrit,
                        'hemoglobin' => $cbc->pHemoglobinG,
                        'mch' => $cbc->pMhcPg,
                        'mcv' => $cbc->pMcvFl,
                        'wbc' => $cbc->pWbc1000,
                        'neutrophils' => $cbc->pNeutrophilsBnd,
                        'lymphocytes' => $cbc->pLymphocytes,
                        'monocytes' => $cbc->pMonocytes,
                        'eosinophils' => $cbc->pEosinophils,
                        'basophils' => $cbc->pBasophils,
                        'platelets' => $cbc->pPlatelet,
                        'lab_status_code' => $cbc->pStatus,
                        'consult_id' => $consultLaboratory->consult_id,
                    ];
                    $consultLaboratory->cbc()->updateOrCreate([
                        'request_id' => $consultLaboratory->id,
                        'patient_id' => $patient->id,
                    ], $cbcData);
                });
            } else {
                $cbcData = [
                    'referral_facility' => $laboratory->CBCS->CBC->pReferralFacility,
                    'laboratory_date' => $laboratory->CBCS->CBC->pLabDate,
                    'hematocrit' => $laboratory->CBCS->CBC->pHematocrit,
                    'hemoglobin' => $laboratory->CBCS->CBC->pHemoglobinG,
                    'mch' => $laboratory->CBCS->CBC->pMhcPg,
                    'mcv' => $laboratory->CBCS->CBC->pMcvFl,
                    'wbc' => $laboratory->CBCS->CBC->pWbc1000,
                    'neutrophils' => $laboratory->CBCS->CBC->pNeutrophilsBnd,
                    'lymphocytes' => $laboratory->CBCS->CBC->pLymphocytes,
                    'monocytes' => $laboratory->CBCS->CBC->pMonocytes,
                    'eosinophils' => $laboratory->CBCS->CBC->pEosinophils,
                    'basophils' => $laboratory->CBCS->CBC->pBasophils,
                    'platelets' => $laboratory->CBCS->CBC->pPlatelet,
                    'lab_status_code' => $laboratory->CBCS->CBC->pStatus,
                    'consult_id' => $consultLaboratory->consult_id,
                ];
                $consultLaboratory->cbc()->updateOrCreate([
                    'request_id' => $consultLaboratory->id,
                    'patient_id' => $patient->id,
                ], $cbcData);
            }
        }

        if (isset($laboratory->URINALYSISS) && $consultLaboratory->lab_code == 'URN') {
            if (is_array($laboratory->URINALYSISS->URINALYSIS)) {
                collect($laboratory->URINALYSISS->URINALYSIS)->map(function ($urinalysis) use ($consultLaboratory, $patient) {
                    $urinalysisData = [
                        'referral_facility' => $urinalysis->pReferralFacility,
                        'laboratory_date' => $urinalysis->pLabDate,
                        'gravity' => $urinalysis->pGravity,
                        'appearance' => $urinalysis->pAppearance,
                        'color' => $urinalysis->pColor,
                        'glucose' => $urinalysis->pGlucose,
                        'proteins' => $urinalysis->pProteins,
                        'ketones' => $urinalysis->pKetones,
                        'ph' => $urinalysis->pPh,
                        'rb_cells' => $urinalysis->pRbCells,
                        'wb_cells' =>  $urinalysis->pWbCells,
                        'bacteria' => $urinalysis->pBacteria,
                        'crystals' => $urinalysis->pCrystals,
                        'bladder_cells' => $urinalysis->pBladderCell,
                        'squamous_cells' => $urinalysis->pSquamousCell,
                        'tubular_cells' => $urinalysis->pTubularCell,
                        'broad_cast' => $urinalysis->pBroadCasts,
                        'epithelial_cast' => $urinalysis->pEpithelialCast,
                        'granular_cast' =>  $urinalysis->pGranularCast,
                        'hyaline_cast' => $urinalysis->pHyalineCast,
                        'rbc_cast' => $urinalysis->pRbcCast,
                        'waxy_cast' => $urinalysis->pWaxyCast,
                        'wc_cast' => $urinalysis->pWcCast,
                        'albumin' => $urinalysis->pAlbumin,
                        'pus_cells' => $urinalysis->pPusCells,
                        'lab_status_code' => $urinalysis->pStatus,
                        'consult_id' => $consultLaboratory->consult_id,
                    ];
                    $consultLaboratory->urinalysis()->updateOrCreate([
                        'request_id' => $consultLaboratory->id,
                        'patient_id' => $patient->id,
                    ], $urinalysisData);
                });
            } else {
                $urinalysisData = [
                    'referral_facility' => $laboratory->URINALYSISS->URINALYSIS->pReferralFacility,
                    'laboratory_date' => $laboratory->URINALYSISS->URINALYSIS->pLabDate,
                    'gravity' => $laboratory->URINALYSISS->URINALYSIS->pGravity,
                    'appearance' => $laboratory->URINALYSISS->URINALYSIS->pAppearance,
                    'color' => $laboratory->URINALYSISS->URINALYSIS->pColor,
                    'glucose' => $laboratory->URINALYSISS->URINALYSIS->pGlucose,
                    'proteins' => $laboratory->URINALYSISS->URINALYSIS->pProteins,
                    'ketones' => $laboratory->URINALYSISS->URINALYSIS->pKetones,
                    'ph' => $laboratory->URINALYSISS->URINALYSIS->pPh,
                    'rb_cells' => $laboratory->URINALYSISS->URINALYSIS->pRbCells,
                    'wb_cells' =>  $laboratory->URINALYSISS->URINALYSIS->pWbCells,
                    'bacteria' => $laboratory->URINALYSISS->URINALYSIS->pBacteria,
                    'crystals' => $laboratory->URINALYSISS->URINALYSIS->pCrystals,
                    'bladder_cells' => $laboratory->URINALYSISS->URINALYSIS->pBladderCell,
                    'squamous_cells' => $laboratory->URINALYSISS->URINALYSIS->pSquamousCell,
                    'tubular_cells' => $laboratory->URINALYSISS->URINALYSIS->pTubularCell,
                    'broad_cast' => $laboratory->URINALYSISS->URINALYSIS->pBroadCasts,
                    'epithelial_cast' => $laboratory->URINALYSISS->URINALYSIS->pEpithelialCast,
                    'granular_cast' =>  $laboratory->URINALYSISS->URINALYSIS->pGranularCast,
                    'hyaline_cast' => $laboratory->URINALYSISS->URINALYSIS->pHyalineCast,
                    'rbc_cast' => $laboratory->URINALYSISS->URINALYSIS->pRbcCast,
                    'waxy_cast' => $laboratory->URINALYSISS->URINALYSIS->pWaxyCast,
                    'wc_cast' => $laboratory->URINALYSISS->URINALYSIS->pWcCast,
                    'albumin' => $laboratory->URINALYSISS->URINALYSIS->pAlbumin,
                    'pus_cells' => $laboratory->URINALYSISS->URINALYSIS->pPusCells,
                    'lab_status_code' => $laboratory->URINALYSISS->URINALYSIS->pStatus,
                    'consult_id' => $consultLaboratory->consult_id,
                ];
                $consultLaboratory->urinalysis()->updateOrCreate([
                    'request_id' => $consultLaboratory->id,
                    'patient_id' => $patient->id,
                ], $urinalysisData);
            }
        }

        if (isset($laboratory->CHESTXRAYS) && $consultLaboratory->lab_code == 'CXRAY') {
            if (is_array($laboratory->CHESTXRAYS->CHESTXRAY)) {
                collect($laboratory->CHESTXRAYS->CHESTXRAY)->map(function ($cxray) use ($consultLaboratory, $patient) {
                    $cxrayData = [
                        'referral_facility' => $cxray->pReferralFacility,
                        'laboratory_date' => $cxray->pLabDate,
                        'findings_code' => $cxray->pFindings,
                        'remarks_findings' => $cxray->pRemarksFindings,
                        'observation_code' => $cxray->pObservation,
                        'remarks_observation' => $cxray->pRemarksObservation,
                        'lab_status_code' => $cxray->pStatus,
                        'consult_id' => $consultLaboratory->consult_id,
                    ];
                    $consultLaboratory->chestXray()->updateOrCreate([
                        'request_id' => $consultLaboratory->id,
                        'patient_id' => $patient->id,
                    ], $cxrayData);
                });
            } else {
                $cxrayData = [
                    'referral_facility' => $laboratory->CHESTXRAYS->CHESTXRAY->pReferralFacility,
                    'laboratory_date' => $laboratory->CHESTXRAYS->CHESTXRAY->pLabDate,
                    'referral_facility' => $laboratory->CHESTXRAYS->CHESTXRAY->pReferralFacility,
                    'laboratory_date' => $laboratory->CHESTXRAYS->CHESTXRAY->pLabDate,
                    'findings_code' => $laboratory->CHESTXRAYS->CHESTXRAY->pFindings,
                    'remarks_findings' => $laboratory->CHESTXRAYS->CHESTXRAY->pRemarksFindings,
                    'observation_code' => $laboratory->CHESTXRAYS->CHESTXRAY->pObservation,
                    'remarks_observation' => $laboratory->CHESTXRAYS->CHESTXRAY->pRemarksObservation,
                    'lab_status_code' => $laboratory->CHESTXRAYS->CHESTXRAY->pStatus,
                    'consult_id' => $consultLaboratory->consult_id,
                ];
                $consultLaboratory->chestXray()->updateOrCreate([
                    'request_id' => $consultLaboratory->id,
                    'patient_id' => $patient->id,
                ], $cxrayData);
            }
        }

        if (isset($laboratory->SPUTUMS) && $consultLaboratory->lab_code == 'SPTM') {
            if (is_array($laboratory->SPUTUMS->SPUTUM)) {
                collect($laboratory->SPUTUMS->SPUTUM)->map(function ($sputum) use ($consultLaboratory, $patient) {
                    $sputumData = [
                        'referral_facility' => $sputum->pReferralFacility,
                        'laboratory_date' => $sputum->pLabDate,
                        'data_collection_code' => $sputum->pDataCollection,
                        'findings_code' => $sputum->pFindings,
                        'remarks' => $sputum->pRemarks,
                        'reading' => $sputum->pNoPlusses,
                        'lab_status_code' => $sputum->pStatus,
                        'consult_id' => $consultLaboratory->consult_id,
                    ];
                    $consultLaboratory->sputum()->updateOrCreate([
                        'request_id' => $consultLaboratory->id,
                        'patient_id' => $patient->id,
                    ], $sputumData);
                });
            } else {
                $sputumData = [
                    'referral_facility' => $laboratory->SPUTUMS->SPUTUM->pReferralFacility,
                    'laboratory_date' => $laboratory->SPUTUMS->SPUTUM->pLabDate,
                    'data_collection_code' => $laboratory->SPUTUMS->SPUTUM->pDataCollection,
                    'findings_code' => $laboratory->SPUTUMS->SPUTUM->pFindings,
                    'remarks' => $laboratory->SPUTUMS->SPUTUM->pRemarks,
                    'reading' => $laboratory->SPUTUMS->SPUTUM->pNoPlusses,
                    'lab_status_code' => $laboratory->SPUTUMS->SPUTUM->pStatus,
                    'consult_id' => $consultLaboratory->consult_id,
                ];
                $consultLaboratory->sputum()->updateOrCreate([
                    'request_id' => $consultLaboratory->id,
                    'patient_id' => $patient->id,
                ], $sputumData);
            }
        }

        if (isset($laboratory->LIPIDPROFILES) && $consultLaboratory->lab_code == 'LPFL') {
            if (is_array($laboratory->LIPIDPROFILES->LIPIDPROFILE)) {
                collect($laboratory->LIPIDPROFILES->LIPIDPROFILE)->map(function ($lipid) use ($consultLaboratory, $patient) {
                    $lipidData = [
                        'referral_facility' => $lipid->pReferralFacility,
                        'laboratory_date' => $lipid->pLabDate,
                        'ldl' => $lipid->pLdl,
                        'hdl' => $lipid->pHdl,
                        'cholesterol' => $lipid->pCholesterol,
                        'triglycerides' => $lipid->pTriglycerides,
                        'lab_status_code' => $lipid->pStatus,
                        'consult_id' => $consultLaboratory->consult_id,
                    ];
                    $consultLaboratory->lipiProfile()->updateOrCreate([
                        'request_id' => $consultLaboratory->id,
                        'patient_id' => $patient->id,
                    ], $lipidData);
                });
            } else {
                $lipidData = [
                    'referral_facility' => $laboratory->LIPIDPROFILES->LIPIDPROFILE->pReferralFacility,
                    'laboratory_date' => $laboratory->LIPIDPROFILES->LIPIDPROFILE->pLabDate,
                    'ldl' => $laboratory->LIPIDPROFILES->LIPIDPROFILE->pLdl,
                    'hdl' => $laboratory->LIPIDPROFILES->LIPIDPROFILE->pHdl,
                    'cholesterol' => $laboratory->LIPIDPROFILES->LIPIDPROFILE->pCholesterol,
                    'triglycerides' => $laboratory->LIPIDPROFILES->LIPIDPROFILE->pTriglycerides,
                    'lab_status_code' => $laboratory->LIPIDPROFILES->LIPIDPROFILE->pStatus,
                    'consult_id' => $consultLaboratory->consult_id,
                ];
                $consultLaboratory->lipiProfile()->updateOrCreate([
                    'request_id' => $consultLaboratory->id,
                    'patient_id' => $patient->id,
                ], $lipidData);
            }
        }

        if (isset($laboratory->FBSS) && $consultLaboratory->lab_code == 'FBS') {
            if (is_array($laboratory->FBSS->FBS)) {
                collect($laboratory->FBSS->FBS)->map(function ($fbs) use ($consultLaboratory, $patient) {
                    $fbsData = [
                        'referral_facility' => $fbs->pReferralFacility,
                        'laboratory_date' => $fbs->pLabDate,
                        'glucose' => $fbs->pGlucoseMg,
                        'lab_status_code' => $fbs->pStatus,
                        'consult_id' => $consultLaboratory->consult_id,
                    ];
                    $consultLaboratory->fbs()->updateOrCreate([
                        'request_id' => $consultLaboratory->id,
                        'patient_id' => $patient->id,
                    ], $fbsData);
                });
            } else {
                $fbsData = [
                    'referral_facility' => $laboratory->FBSS->FBS->pReferralFacility,
                    'laboratory_date' => $laboratory->FBSS->FBS->pLabDate,
                    'glucose' => $laboratory->FBSS->FBS->pGlucoseMg,
                    'lab_status_code' => $laboratory->FBSS->FBS->pStatus,
                    'consult_id' => $consultLaboratory->consult_id,
                ];
                $consultLaboratory->fbs()->updateOrCreate([
                    'request_id' => $consultLaboratory->id,
                    'patient_id' => $patient->id,
                ], $fbsData);
            }
        }

        if (isset($laboratory->RBSS) && $consultLaboratory->lab_code == 'RBS') {
            if (is_array($laboratory->RBSS->RBS)) {
                collect($laboratory->RBSS->RBS)->map(function ($rbs) use ($consultLaboratory, $patient) {
                    $rbsData = [
                        'referral_facility' => $rbs->pReferralFacility,
                        'laboratory_date' => $rbs->pLabDate,
                        'glucose' => $rbs->pGlucoseMg,
                        'lab_status_code' => $rbs->pStatus,
                        'consult_id' => $consultLaboratory->consult_id,
                    ];
                    $consultLaboratory->rbs()->updateOrCreate([
                        'request_id' => $consultLaboratory->id,
                        'patient_id' => $patient->id,
                    ], $rbsData);
                });
            } else {
                $rbsData = [
                    'referral_facility' => $laboratory->RBSS->RBS->pReferralFacility,
                    'laboratory_date' => $laboratory->RBSS->RBS->pLabDate,
                    'glucose' => $laboratory->RBSS->RBS->pGlucoseMg,
                    'lab_status_code' => $laboratory->RBSS->RBS->pStatus,
                    'consult_id' => $consultLaboratory->consult_id,
                ];
                $consultLaboratory->rbs()->updateOrCreate([
                    'request_id' => $consultLaboratory->id,
                    'patient_id' => $patient->id,
                ], $rbsData);
            }
        }

        if (isset($laboratory->ECGS) && $consultLaboratory->lab_code == 'ECG') {
            if (is_array($laboratory->ECGS->ECG)) {
                collect($laboratory->ECGS->ECG)->map(function ($ecg) use ($consultLaboratory, $patient) {
                    $ecgData = [
                        'referral_facility' => $ecg->pReferralFacility,
                        'laboratory_date' => $ecg->pLabDate,
                        'findings_code' => $ecg->pFindings,
                        'remarks' => $ecg->pRemarks,
                        'lab_status_code' => $ecg->pStatus,
                        'consult_id' => $consultLaboratory->consult_id,
                    ];
                    $consultLaboratory->ecg()->updateOrCreate([
                        'request_id' => $consultLaboratory->id,
                        'patient_id' => $patient->id,
                    ], $ecgData);
                });
            } else {
                $ecgData = [
                    'referral_facility' => $laboratory->ECGS->ECG->pReferralFacility,
                    'laboratory_date' => $laboratory->ECGS->ECG->pLabDate,
                    'findings_code' => $laboratory->ECGS->ECG->pFindings,
                    'remarks' => $laboratory->ECGS->ECG->pRemarks,
                    'lab_status_code' => $laboratory->ECGS->ECG->pStatus,
                    'consult_id' => $consultLaboratory->consult_id,
                ];
                $consultLaboratory->ecg()->updateOrCreate([
                    'request_id' => $consultLaboratory->id,
                    'patient_id' => $patient->id,
                ], $ecgData);
            }
        }

        if (isset($laboratory->FECALYSISS) && $consultLaboratory->lab_code == 'FCAL') {
            if (is_array($laboratory->FECALYSISS->FECALYSIS)) {
                collect($laboratory->FECALYSISS->FECALYSIS)->map(function ($fecalysis) use ($consultLaboratory, $patient) {
                    $fecalysisData = [
                        'referral_facility' => $fecalysis->pReferralFacility,
                        'laboratory_date' => $fecalysis->pLabDate,
                        'color_code' => $fecalysis->pColor,
                        'consistency_code' => $fecalysis->pConsistency,
                        'rbc' => $fecalysis->pRbc,
                        'wbc' => $fecalysis->pWbc,
                        'ova' => $fecalysis->pOva,
                        'parasite' => $fecalysis->pParasite,
                        'blood_code' => $fecalysis->pBlood,
                        'pus_cells' => $fecalysis->pPusCells,
                        'lab_status_code' => $fecalysis->pStatus,
                        'consult_id' => $consultLaboratory->consult_id,
                    ];
                    $consultLaboratory->fecalysis()->updateOrCreate([
                        'request_id' => $consultLaboratory->id,
                        'patient_id' => $patient->id,
                    ], $fecalysisData);
                });
            } else {
                $fecalysisData = [
                    'referral_facility' => $laboratory->FECALYSISS->FECALYSIS->pReferralFacility,
                    'laboratory_date' => $laboratory->FECALYSISS->FECALYSIS->pLabDate,
                    'color_code' => $laboratory->FECALYSISS->FECALYSIS->pColor,
                    'consistency_code' => $laboratory->FECALYSISS->FECALYSIS->pConsistency,
                    'rbc' => $laboratory->FECALYSISS->FECALYSIS->pRbc,
                    'wbc' => $laboratory->FECALYSISS->FECALYSIS->pWbc,
                    'ova' => $laboratory->FECALYSISS->FECALYSIS->pOva,
                    'parasite' => $laboratory->FECALYSISS->FECALYSIS->pParasite,
                    'blood_code' => $laboratory->FECALYSISS->FECALYSIS->pBlood,
                    'pus_cells' => $laboratory->FECALYSISS->FECALYSIS->pPusCells,
                    'lab_status_code' => $laboratory->FECALYSISS->FECALYSIS->pStatus,
                    'consult_id' => $consultLaboratory->consult_id,
                ];
                $consultLaboratory->fecalysis()->updateOrCreate([
                    'request_id' => $consultLaboratory->id,
                    'patient_id' => $patient->id,
                ], $fecalysisData);
            }
        }

        if (isset($laboratory->PAPSMEARS) && $consultLaboratory->lab_code == 'PSMR') {
            if (is_array($laboratory->PAPSMEARS->PAPSMEAR)) {
                collect($laboratory->PAPSMEARS->PAPSMEAR)->map(function ($papsmear) use ($consultLaboratory, $patient) {
                    $papsmearData = [
                        'referral_facility' => $papsmear->pReferralFacility,
                        'laboratory_date' => $papsmear->pLabDate,
                        'findings' => $papsmear->pFindings,
                        'impression' => $papsmear->pImpression,
                        'lab_status_code' => $papsmear->pStatus,
                        'consult_id' => $consultLaboratory->consult_id,
                    ];
                    $consultLaboratory->papsmear()->updateOrCreate([
                        'request_id' => $consultLaboratory->id,
                        'patient_id' => $patient->id,
                    ], $papsmearData);
                });
            } else {
                $papsmearData = [
                    'referral_facility' => $laboratory->PAPSMEARS->PAPSMEAR->pReferralFacility,
                    'laboratory_date' => $laboratory->PAPSMEARS->PAPSMEAR->pLabDate,
                    'findings' => $laboratory->PAPSMEARS->PAPSMEAR->pFindings,
                    'impression' => $laboratory->PAPSMEARS->PAPSMEAR->pImpression,
                    'lab_status_code' => $laboratory->PAPSMEARS->PAPSMEAR->pStatus,
                    'consult_id' => $consultLaboratory->consult_id,
                ];
                $consultLaboratory->papsmear()->updateOrCreate([
                    'request_id' => $consultLaboratory->id,
                    'patient_id' => $patient->id,
                ], $papsmearData);
            }
        }

        if (isset($laboratory->OGTTS) && $consultLaboratory->lab_code == 'OGTT') {
            if (is_array($laboratory->OGTTS->OGTT)) {
                collect($laboratory->OGTTS->OGTT)->map(function ($ogtt) use ($consultLaboratory, $patient) {
                    $ogttData = [
                        'referral_facility' => $ogtt->pReferralFacility,
                        'laboratory_date' => $ogtt->pLabDate,
                        'fasting_exam_mg' => $ogtt->pExamFastingMg,
                        'fasting_exam_mmol' => $ogtt->pExamFastingMmol,
                        'ogtt_one_hour_mg' => $ogtt->pExamOgttOneHrMg,
                        'ogtt_one_hour_mmol' => $ogtt->pExamOgttOneHrMmol,
                        'ogtt_two_hour_mg' => $ogtt->pExamOgttTwoHrMg,
                        'ogtt_two_hour_mmol' => $ogtt->pExamOgttTwoHrMmol,
                        'lab_status_code' => $ogtt->pStatus,
                        'consult_id' => $consultLaboratory->consult_id,
                    ];
                    $consultLaboratory->oralGlucose()->updateOrCreate([
                        'request_id' => $consultLaboratory->id,
                        'patient_id' => $patient->id,
                    ], $ogttData);
                });
            } else {
                $ogttData = [
                    'referral_facility' => $laboratory->OGTTS->OGTT->pReferralFacility,
                    'laboratory_date' => $laboratory->OGTTS->OGTT->pLabDate,
                    'fasting_exam_mg' => $laboratory->OGTTS->OGTT->pExamFastingMg,
                    'fasting_exam_mmol' => $laboratory->OGTTS->OGTT->pExamFastingMmol,
                    'ogtt_one_hour_mg' => $laboratory->OGTTS->OGTT->pExamOgttOneHrMg,
                    'ogtt_one_hour_mmol' => $laboratory->OGTTS->OGTT->pExamOgttOneHrMmol,
                    'ogtt_two_hour_mg' => $laboratory->OGTTS->OGTT->pExamOgttTwoHrMg,
                    'ogtt_two_hour_mmol' => $laboratory->OGTTS->OGTT->pExamOgttTwoHrMmol,
                    'lab_status_code' => $laboratory->OGTTS->OGTT->pStatus,
                    'consult_id' => $consultLaboratory->consult_id,
                ];
                $consultLaboratory->oralGlucose()->updateOrCreate([
                    'request_id' => $consultLaboratory->id,
                    'patient_id' => $patient->id,
                ], $ogttData);
            }
        }

        if (isset($laboratory->FOBTS) && $consultLaboratory->lab_code == 'FOBT') {
            if (is_array($laboratory->FOBTS->FOBT)) {
                collect($laboratory->FOBTS->FOBT)->map(function ($fobt) use ($consultLaboratory, $patient) {
                    $fobtData = [
                        'referral_facility' => $fobt->pReferralFacility,
                        'laboratory_date' => $fobt->pLabDate,
                        'findings_code' => $fobt->pFindings,
                        'lab_status_code' => $fobt->pStatus,
                        'consult_id' => $consultLaboratory->consult_id,
                    ];
                    $consultLaboratory->fecalOccult()->updateOrCreate([
                        'request_id' => $consultLaboratory->id,
                        'patient_id' => $patient->id,
                    ], $fobtData);
                });
            } else {
                $fobtData = [
                    'referral_facility' => $laboratory->FOBTS->FOBT->pReferralFacility,
                    'laboratory_date' => $laboratory->FOBTS->FOBT->pLabDate,
                    'findings_code' => $laboratory->FOBTS->FOBT->pFindings,
                    'lab_status_code' => $laboratory->FOBTS->FOBT->pStatus,
                    'consult_id' => $consultLaboratory->consult_id,
                ];
                $consultLaboratory->fecalOccult()->updateOrCreate([
                    'request_id' => $consultLaboratory->id,
                    'patient_id' => $patient->id,
                ], $fobtData);
            }
        }

        if (isset($laboratory->CREATININES) && $consultLaboratory->lab_code == 'CRTN') {
            if (is_array($laboratory->CREATININES->CREATININE)) {
                collect($laboratory->CREATININES->CREATININE)->map(function ($creatinine) use ($consultLaboratory, $patient) {
                    $creatinineData = [
                        'referral_facility' => $creatinine->pReferralFacility,
                        'laboratory_date' => $creatinine->pLabDate,
                        'findings' => $creatinine->pFindings,
                        'lab_status_code' => $creatinine->pStatus,
                        'consult_id' => $consultLaboratory->consult_id,
                    ];
                    $consultLaboratory->creatinine()->updateOrCreate([
                        'request_id' => $consultLaboratory->id,
                        'patient_id' => $patient->id,
                    ], $creatinineData);
                });
            } else {
                $creatinineData = [
                    'referral_facility' => $laboratory->CREATININES->CREATININE->pReferralFacility,
                    'laboratory_date' => $laboratory->CREATININES->CREATININE->pLabDate,
                    'findings' => $laboratory->CREATININES->CREATININE->pFindings,
                    'lab_status_code' => $laboratory->CREATININES->CREATININE->pStatus,
                    'consult_id' => $consultLaboratory->consult_id,
                ];
                $consultLaboratory->creatinine()->updateOrCreate([
                    'request_id' => $consultLaboratory->id,
                    'patient_id' => $patient->id,
                ], $creatinineData);
            }
        }

        if (isset($laboratory->PPDTests) && $consultLaboratory->lab_code == 'PPD') {
            if (is_array($laboratory->PPDTests->PPDTest)) {
                collect($laboratory->PPDTests->PPDTest)->map(function ($ppd) use ($consultLaboratory, $patient) {
                    $ppdData = [
                        'referral_facility' => $ppd->pReferralFacility,
                        'laboratory_date' => $ppd->pLabDate,
                        'findings_code' => $ppd->pFindings,
                        'lab_status_code' => $ppd->pStatus,
                        'consult_id' => $consultLaboratory->consult_id,
                    ];
                    $consultLaboratory->ppd()->updateOrCreate([
                        'request_id' => $consultLaboratory->id,
                        'patient_id' => $patient->id,
                    ], $ppdData);
                });
            } else {
                $ppdData = [
                    'referral_facility' => $laboratory->PPDTests->PPDTest->pReferralFacility,
                    'laboratory_date' => $laboratory->PPDTests->PPDTest->pLabDate,
                    'findings_code' => $laboratory->PPDTests->PPDTest->pFindings,
                    'lab_status_code' => $laboratory->PPDTests->PPDTest->pStatus,
                    'consult_id' => $consultLaboratory->consult_id,
                ];
                $consultLaboratory->ppd()->updateOrCreate([
                    'request_id' => $consultLaboratory->id,
                    'patient_id' => $patient->id,
                ], $ppdData);
            }
        }

        if (isset($laboratory->HbA1cs) && $consultLaboratory->lab_code == 'HBA') {
            if (is_array($laboratory->HbA1cs->HbA1c)) {
                collect($laboratory->HbA1cs->HbA1c)->map(function ($hba) use ($consultLaboratory, $patient) {
                    $hbaData = [
                        'referral_facility' => $hba->pReferralFacility,
                        'laboratory_date' => $hba->pLabDate,
                        'findings_code' => $hba->pFindings,
                        'lab_status_code' => $hba->pStatus,
                        'consult_id' => $consultLaboratory->consult_id,
                    ];
                    $consultLaboratory->hba1c()->updateOrCreate([
                        'request_id' => $consultLaboratory->id,
                        'patient_id' => $patient->id,
                    ], $hbaData);
                });
            } else {
                $ppdData = [
                    'referral_facility' => $laboratory->HbA1cs->HbA1c->pReferralFacility,
                    'laboratory_date' => $laboratory->HbA1cs->HbA1c->pLabDate,
                    'findings_code' => $laboratory->HbA1cs->HbA1c->pFindings,
                    'lab_status_code' => $laboratory->HbA1cs->HbA1c->pStatus,
                    'consult_id' => $consultLaboratory->consult_id,
                ];
                $consultLaboratory->hba1c()->updateOrCreate([
                    'request_id' => $consultLaboratory->id,
                    'patient_id' => $patient->id,
                ], $ppdData);
            }
        }
    }

}
