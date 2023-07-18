<?php

namespace App\Services\Eclaims;

use App\Http\Resources\API\V1\Eclaims\EclaimsXmlCf1Resource;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PhilHealth\PhilhealthCredential;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Spatie\ArrayToXml\ArrayToXml;

class EclaimsXmlService
{
    public function createXml($transmittalNumber, $patientId, $request)
    {
        $creds = PhilhealthCredential::whereFacilityCode($request->facility_code)->whereProgramCode($request->program_desc)->first();
        if (empty($transmittalNumber)) {
            $prefix = $creds->accreditation_number.date('Ym');
            $transmittalNumber = IdGenerator::generate(['table' => 'eclaims_uploads', 'field' => 'pHospitalTransmittalNo', 'length' => 21, 'prefix' => $prefix, 'reset_on_prefix_change' => true]);
        }

        // $transmittalNumber = 'test';
        $root = [
            'rootElementName' => 'eCLAIMS',
            '_attributes' => [
                'pUserName' => '',
                'pUserPassword' => '',
                'pHospitalCode' => $creds->accreditation_number,
                'pHospitalEmail' => '',
                'pServiceProvider' => 'WAH',
            ],
        ];

        $etransmittal = $this->etransmittal($transmittalNumber);
        $claim = $this->claim($transmittalNumber);
        $cf1 = $this->cf1($patientId);
        $cf2 = $this->cf2($request);
        $allcaserate = $this->allcaserate($request);

        $array = [];
        $array['eTRANSMITTAL'] = $etransmittal;
        $array['eTRANSMITTAL']['CLAIM'] = [$claim];
        $array['eTRANSMITTAL']['CLAIM'][0]['CF1'] = $cf1;
        $array['eTRANSMITTAL']['CLAIM'][0]['CF2'] = $cf2;
        $array['eTRANSMITTAL']['CLAIM'][0]['ALLCASERATE'] = $allcaserate;

        // $request->case_info['patient_id']
        // $request->case_info['caserate_code']

        // return $array;
        $result = new ArrayToXml($array, $root, true, 'UTF-8');
        $xml = $result->dropXmlDeclaration()->toXml();

        return $xml;
    }

    public function etransmittal($transmittalNumber)
    {
        return [
            '_attributes' => [
                'pHospitalTransmittalNo' => $transmittalNumber,
                'pTotalClaims' => '1',
            ],
        ];
    }

    public function claim($transmittalNumber)
    {
        return [
            '_attributes' => [
                'pClaimNumber' => $transmittalNumber,
                'pTrackingNumber' => '',
                'pPhilhealthClaimType' => 'ALL-CASE-RATE',
                'pPatientType' => 'O',
                'pIsEmergency' => 'N',
            ],
        ];
    }

    public function cf1($id)
    {
        $cf1 = [];
        // $patient = Patient::selectRaw('id AS patientID, first_name, middle_name, last_name, suffix_name, gender, birthdate, mobile_number');
        $data = Patient::selectRaw('last_name, first_name, middle_name, suffix_name, birthdate, gender, mobile_number,
                    philhealth_id, membership_type_id, member_relation_id, employer_pin, employer_name,
                    mobile_number, member_gender, philhealth_id, address,
                    barangays.name AS barangay_name, municipalities.name AS muncipality_name, provinces.name AS province_name,
                    philhealth_cat_id')
            ->join('patient_philhealth', 'patients.id', '=', 'patient_philhealth.patient_id')
            ->join('household_members', 'patients.id', '=', 'household_members.patient_id')
            ->join('household_folders', 'household_members.household_folder_id', '=', 'household_folders.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
            ->join('lib_philhealth_membership_categories', 'patient_philhealth.membership_category_id', '=', 'lib_philhealth_membership_categories.id')
            ->where('patients.id', '=', $id)
            ->orderBy('effectivity_year', 'DESC')
            ->first();

        return EclaimsXmlCf1Resource::make($data)->resolve(); //[$cf1];
    }

    public function allcaserate($request)
    {
        $allcaserate = [
            'CASERATE' => [
                '_attributes' => [
                    'pCaseRateCode' => $request->caserate_code,
                    'pICDCode' => '',
                    'pRVSCode' => $request->code,
                    'pCaseRateAmount' => $request->caserate_fee,
                ],
            ],
        ];

        return $allcaserate;
    }

    public function cf2($request)
    {
        $cf2 = [
            '_attributes' => [
                'pPatientReferred' => 'N',
                'pReferredIHCPAccreCode' => '',
                'pAdmissionDate' => $request->admission_date,
                'pAdmissionTime' => $request->admission_time,
                'pDischargeDate' => $request->discharge_date,
                'pDischargeTime' => $request->discharge_time,
                'pDisposition' => 'I',
                'pExpiredDate' => '',
                'pExpiredTime' => '',
                'pReferralIHCPAccreCode' => '',
                'pReferralReasons' => '',
                'pAccommodationType' => 'N',
                'pHasAttachedSOA' => 'N',
            ],
        ];

        $diagnosis = [
            '_attributes' => [
                'pAdmissionDiagnosis' => $request->admit_dx,
            ],
            'DISCHARGE' => [
                '_attributes' => [
                    'pDischargeDiagnosis' => $request->description,
                ],
                'RVSCODES' => [
                    '_attributes' => [
                        'pRelatedProcedure' => $request->description,
                        'pRVSCode' => $request->code,
                        'pProcedureDate' => $request->attendant_sign_date,
                        'pLaterality' => 'N',
                    ],
                ],
            ],
        ];

        $special = $this->tbdots($request);

        $consumption = [
            'BENEFITS' => [
                '_attributes' => [
                    'pTotalHCIFees' => $request->hci_fee,
                    'pTotalProfFees' => $request->prof_fee,
                    'pGrandTotal' => $request->caserate_fee,
                ],
            ],
        ];

        $professional = [
            '_attributes' => [
                'pDoctorAccreCode' => $request->attendant_accreditation_code,
                'pDoctorLastName' => $request->attendant_last_name,
                'pDoctorFirstName' => $request->attendant_first_name,
                'pDoctorMiddleName' => $request->attendant_middle_name,
                'pDoctorSuffix' => $request->attendant_suffix_name,
                'pWithCoPay' => 'N',
                'pDoctorCoPay' => '',
                'pDoctorSignDate' => $request->attendant_sign_date,
            ],
        ];

        $array = [];
        $array = $cf2;
        $array['DIAGNOSIS'] = $diagnosis;
        $array['SPECIAL'] = $special;
        $array['PROFESSIONALS'] = $professional;
        $array['CONSUMPTION'] = $consumption;

        return $array;
    }

    public function mcp($request)
    {
        return [
            'MCP' => [
                '_attributes' => [
                    'pCheckUpDate1' => $request->pCheckUpDate1,
                    'pCheckUpDate2' => $request->pCheckUpDate2,
                    'pCheckUpDate3' => $request->pCheckUpDate3,
                    'pCheckUpDate4' => $request->pCheckUpDate4,
                ],
            ],
        ];
    }

    public function ncp($request)
    {
        return [
            'NCP' => [
                '_attributes' => [
                    'pEssentialNewbornCare' => $request->pEssentialNewbornCare,
                    'pNewbornHearingScreeningTest' => $request->pNewbornHearingScreeningTest,
                    'pNewbornScreeningTest' => $request->pNewbornScreeningTest,
                    'pFilterCardNo' => $request->pFilterCardNo,
                ],
                'ESSENTIAL' => [
                    '_attributes' => [
                        'pDrying' => 'Y',
                        'pSkinToSkin' => 'Y',
                        'pCordClamping' => 'Y',
                        'pProphylaxis' => 'Y',
                        'pWeighing' => 'Y',
                        'pVitaminK' => 'Y',
                        'pBCG' => 'Y',
                        'pNonSeparation' => 'Y',
                        'pHepatitisB' => 'Y',
                    ],
                ],
            ],
        ];
    }

    public function tbdots($request)
    {
        return [
            'TBDOTS' => [
                '_attributes' => [
                    'pTBType' => $request->pTBType,
                    'pNTPCardNo' => $request->pNTPCardNo,
                ],
            ],
        ];
    }

    public function abp($request)
    {
        return [
            'ABP' => [
                '_attributes' => [
                    'pDay0ARV' => $request->pDay0ARV,
                    'pDay3ARV' => $request->pDay3ARV,
                    'pDay7ARV' => $request->pDay7ARV,
                    'pRIG' => $request->pRIG,
                    'pABPOthers' => $request->pABPOthers,
                    'pABPSpecify' => $request->pABPSpecify,
                ],
            ],
        ];
    }
}
