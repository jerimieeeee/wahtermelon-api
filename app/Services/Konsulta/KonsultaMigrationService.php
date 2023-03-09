<?php

namespace App\Services\Konsulta;

use App\Models\V1\Consultation\Consult;
use App\Models\V1\Laboratory\ConsultLaboratory;
use App\Models\V1\Libraries\LibComplaint;
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
            $this->saveSubjective($soap, $patient, $value);
        } else{
            $soap = collect($value->SOAPS)->where('pHciCaseNo', $patient->case_number)->first();
            $this->saveSubjective($soap, $patient, $value);
        }
    }

    /**
     * @param mixed $soap
     * @param $patient
     * @param $value
     * @return void
     */
    public function saveSubjective(mixed $soap, $patient, $value)
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
            if (isset($soap->SUBJECTIVE)) {
                $notes = $consult->consultNotes()->updateOrCreate(['consult_id' => $consult->id, 'patient_id' => $consult->patient_id], [
                    'history' => $soap->SUBJECTIVE->pIllnessHistory,
                    'complaint' => $soap->SUBJECTIVE->pOtherComplaint
                ]);
                $konsultaComplaints = explode(';', $soap->SUBJECTIVE->pSignsSymptoms);
                foreach ($konsultaComplaints as $value) {
                    $complaintId = LibComplaint::query()
                        ->when($value == '38', fn($query) => $query->where('complaint_desc', 'LIKE', '%' . $soap->SUBJECTIVE->pPainSite . '%'))
                        ->when($value != '38', fn($query) => $query->where('konsulta_complaint_id', $value))
                        ->first();
                    $complaint = $notes->complaints()->updateOrCreate(['notes_id' => $notes->id, 'consult_id' => $consult->id, 'patient_id' => $patient->id, 'complaint_id' => $complaintId->complaint_id]);
                }
            }
//            if (isset($soap->PEMISCS)) {
//                if (is_array($soap->PEMISCS->PEMISC)) {
//                    return collect($soap->PEMISCS->PEMISC)->map(function ($pe) use ($notes) {
//                        $this->physicalExam($pe, $notes);
//                    });
//                } else {
//                    $this->physicalExam($soap->PEMISCS->PEMISC, $notes);
//                }
//            }
        }
    }

}
