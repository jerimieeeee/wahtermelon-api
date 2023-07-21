<?php

namespace App\Services\Eclaims;

use App\Http\Resources\API\V1\Eclaims\EclaimsXmlCf1Resource;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PhilHealth\PhilhealthCredential;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Spatie\ArrayToXml\ArrayToXml;

class EclaimsXmlService
{
    public function createXml($transmittalNumber, $patientId, $request)
    {
        $creds = PhilhealthCredential::where('facility_code',auth()->user()->facility_code)
                ->where('program_code', $request->program_desc != 'cc' ? $request->program_desc : 'mc')
                ->first();
        // return $creds = auth()->user()->eclaimsCredential($request->program_desc);//PhilhealthCredential::whereFacilityCode($request->facility_code)->whereProgramCode($request->program_desc)->first();
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
        $documents = $this->documents();

        $array = [];
        $array['eTRANSMITTAL'] = $etransmittal;
        $array['eTRANSMITTAL']['CLAIM'] = [$claim];
        $array['eTRANSMITTAL']['CLAIM'][0]['CF1'] = $cf1;
        $array['eTRANSMITTAL']['CLAIM'][0]['CF2'] = $cf2;
        $array['eTRANSMITTAL']['CLAIM'][0]['ALLCASERATE'] = $allcaserate;
        $array['eTRANSMITTAL']['CLAIM'][0]['DOCUMENTS'] = $documents;

        // $request->case_info['patient_id']
        // $request->case_info['caserate_code']

        // return $array;
        $result = new ArrayToXml($array, $root, true, 'UTF-8');
        $xml = $result->dropXmlDeclaration()->toXml();

        return ['transmittalNumber' => $transmittalNumber, 'xml' => $xml, 'cipher_key' => $creds->cipher_key];
    }

    public function documents()
    {

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
                    philhealth_id, membership_type_id, employer_pin, employer_name,
                    mobile_number, philhealth_id, address,
                    member_birthdate, member_gender, member_relation_id, member_pin, member_last_name,
                    member_first_name, member_middle_name, member_suffix_name,
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
                    'pICDCode' => $request->icd10_code,
                    'pRVSCode' => $request->code,
                    'pCaseRateAmount' => (int)$request->caserate_fee,
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
                'pAdmissionDate' => Carbon::parse($request->admission_date)->format('m-d-Y'),
                'pAdmissionTime' => $request->admission_time,
                'pDischargeDate' => Carbon::parse($request->discharge_date)->format('m-d-Y'),
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
                    'pDischargeDiagnosis' => $request->discharge_dx,
                ],
                'RVSCODES' => [
                    '_attributes' => [
                        'pRelatedProcedure' => $request->description,
                        'pRVSCode' => $request->code,
                        'pProcedureDate' => Carbon::parse($request->attendant_sign_date)->format('m-d-Y'),
                        'pLaterality' => 'N',
                    ],
                ],
            ],
        ];

        if($request->program_desc === 'tb') {
            $special = $this->tbdots($request);
        }

        if($request->program_desc === 'cc') {
            $special = $this->ncp($request);
        }
        $consumption = [
            '_attributes' => [
                'pEnoughBenefits' => 'Y',
            ],
            'BENEFITS' => [
                '_attributes' => [
                    'pTotalHCIFees' => (int)$request->hci_fee,
                    'pTotalProfFees' => (int)$request->prof_fee,
                    'pGrandTotal' => (int)$request->caserate_fee,
                ],
            ],
        ];

        $professional = [
            '_attributes' => [
                'pDoctorAccreCode' => '',//$request->attendant_accreditation_code,
                'pDoctorLastName' => $request->attendant_last_name,
                'pDoctorFirstName' => $request->attendant_first_name,
                'pDoctorMiddleName' => $request->attendant_middle_name,
                'pDoctorSuffix' => $request->attendant_suffix_name,
                'pWithCoPay' => 'N',
                'pDoctorCoPay' => '',
                'pDoctorSignDate' => Carbon::parse($request->attendant_sign_date)->format('m-d-Y'),
            ],
        ];
//substr_replace(substr_replace($request->attendant_accreditation_code, '-', 11, 0), '-', 4, 0)
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
                    'pCheckUpDate1' => Carbon::parse($request->pCheckUpDate1)->format('m-d-Y'),
                    'pCheckUpDate2' => Carbon::parse($request->pCheckUpDate2)->format('m-d-Y'),
                    'pCheckUpDate3' => Carbon::parse($request->pCheckUpDate3)->format('m-d-Y'),
                    'pCheckUpDate4' => Carbon::parse($request->pCheckUpDate4)->format('m-d-Y'),
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
