<?php

namespace App\Http\Controllers\API\V1\Eclaims;

use App\Classes\PhilHealthEClaimsEncryptor;
use App\Http\Controllers\Controller;
use App\Models\V1\PhilHealth\PhilhealthCredential;
use App\Services\PhilHealth\SoapService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * @authenticated
 *
 * @group eClaims Information
 *
 * APIs for managing eClaims Information
 *
 * @subgroup eClaims
 *
 * @subgroupDescription eClaims.
 */
class EclaimsSyncController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function checkWS(SoapService $service)
    {

        return $service->_client()->checkWS();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function SearchCaseRate(Request $request, SoapService $service)
    {
        $data = PhilhealthCredential::whereProgramCode($request->program_code)->first();

        $encrypted = $service->_client()->SearchCaseRate(
            $data->username.':'.$data->software_certification_id,
            $data->password,
            $data->pmcc_number,
            $request->icd10,
            $request->rvs,
            $request->description);

        $decryptor = new PhilHealthEClaimsEncryptor();

        return XML2JSON($decryptor->decryptPayloadDataToXml($encrypted, $data->cipher_key));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function GetMemberPIN(Request $request, SoapService $service)
    {
        $data = PhilhealthCredential::whereProgramCode($request->program_code)->first();

        $pin = $service->_client()->GetMemberPIN(
            $data->username.':'.$data->software_certification_id,
            $data->password,
            $data->pmcc_number,
            $request->last_name,
            $request->first_name,
            $request->middle_name,
            $request->suffix_name,
            $request->birthdate,
        );
        if (Str::contains($pin, 'NO RECORDS FOUND')) {
            $status = 404;
        } else {
            $status = 200;
        }

        return response()->json(['data' => $pin], $status);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function SearchHospital(Request $request, SoapService $service)
    {
        $data = PhilhealthCredential::whereProgramCode($request->program_code)->first();

        $encrypted = $service->_client()->SearchHospital(
            $data->username.':'.$data->software_certification_id,
            $data->password,
            $data->pmcc_number,
        );

        $decryptor = new PhilHealthEClaimsEncryptor();

        return XML2JSON($decryptor->decryptPayloadDataToXml($encrypted, $data->cipher_key));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function SearchEmployer(Request $request, SoapService $service)
    {
        $data = PhilhealthCredential::whereProgramCode($request->program_code)->first();

        $encrypted = $service->_client()->SearchEmployer(
            $data->username.':'.$data->software_certification_id,
            $data->password,
            $data->pmcc_number,
            '',
            '%'.$request->employer_name.'%'
        );

        $decryptor = new PhilHealthEClaimsEncryptor();

        return XML2JSON($decryptor->decryptPayloadDataToXml($encrypted, $data->cipher_key));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function GetDoctorPAN(Request $request, SoapService $service)
    {
        $data = PhilhealthCredential::whereProgramCode($request->program_code)->first();

        $encrypted = $service->_client()->GetDoctorPAN(
            $data->username.':'.$data->software_certification_id,
            $data->password,
            $data->pmcc_number,
            $request->tin_number,
            $request->last_name,
            $request->first_name,
            $request->middle_name,
            $request->suffix_name,
            $request->birthdate,
        );

        $decryptor = new PhilHealthEClaimsEncryptor();

        return XML2JSON($decryptor->decryptPayloadDataToXml($encrypted, $data->cipher_key));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function GetClaimStatus(Request $request, SoapService $service)
    {
        $data = PhilhealthCredential::whereProgramCode($request->program_code)->first();

        $encrypted = $service->_client()->GetClaimStatus(
            $data->username.':'.$data->software_certification_id,
            $data->password,
            $data->pmcc_number,
            $request->series_lhio,
        );

        $decryptor = new PhilHealthEClaimsEncryptor();

        return XML2JSON($decryptor->decryptPayloadDataToXml($encrypted, $data->cipher_key));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function GetVoucherDetails(Request $request, SoapService $service)
    {
        $data = PhilhealthCredential::whereProgramCode($request->program_code)->first();

        $encrypted = $service->_client()->GetVoucherDetails(
            $data->username.':'.$data->software_certification_id,
            $data->password,
            $data->pmcc_number,
            $request->voucher_no,
        );

        $decryptor = new PhilHealthEClaimsEncryptor();

        return XML2JSON($decryptor->decryptPayloadDataToXml($encrypted, $data->cipher_key));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function isClaimEligible(Request $request, SoapService $service)
    {
        $data = PhilhealthCredential::whereProgramCode($request->program_code)->first();

        $encrypted = $service->_client()->isClaimEligible(
            $data->username.':'.$data->software_certification_id,
            $data->password,
            $data->pmcc_number,
            $request->member_pin,
            $request->member_last_name,
            $request->member_first_name,
            $request->member_middle_name,
            $request->member_suffix_name,
            $request->member_birthdate,
            '',
            '',
            $request->patient_is,
            $request->admission_date,
            $request->discharge_date,
            $request->patient_last_name,
            $request->patient_first_name,
            $request->patient_middle_name,
            $request->patient_suffix_name,
            $request->patient_birthdate,
            $request->patient_gender,
            '',
            '',
            '',
            '',
            '',
            '',
            '1',
        );

        $decryptor = new PhilHealthEClaimsEncryptor();

        return XML2JSON($decryptor->decryptPayloadDataToXml($encrypted, $data->cipher_key));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function isDoctorAccredited(Request $request, SoapService $service)
    {
        $data = PhilhealthCredential::whereProgramCode($request->program_code)->first();

        $encrypted = $service->_client()->isDoctorAccredited(
            $data->username.':'.$data->software_certification_id,
            $data->password,
            $data->pmcc_number,
            $request->accreditation_code,
            $request->admission_date,
            $request->discharge_date,
        );

        $decryptor = new PhilHealthEClaimsEncryptor();

        return XML2JSON($decryptor->decryptPayloadDataToXml($encrypted, $data->cipher_key));
    }

    public function eClaimsUpload(Request $request, SoapService $service)
    {
        $data = PhilhealthCredential::whereProgramCode($request->program_code)->first();

        $encrypted = $service->_client()->isDoctorAccredited(
            $data->username.':'.$data->software_certification_id,
            $data->password,
            $data->pmcc_number,
            $request->encryptedXml
        );

        $decryptor = new PhilHealthEClaimsEncryptor();

        try {
            return XML2JSON($decryptor->decryptPayloadDataToXml($encrypted, $data->cipher_key));
        } catch (Exception $e) {
            $desc = $e->getMessage();

            return $desc;
        }
    }

    public function getUploadedClaimsMap(Request $request, SoapService $service)
    {
        $data = PhilhealthCredential::whereProgramCode($request->program_code)->first();

        $encrypted = $service->_client()->GetUploadedClaimsMap(
            $data->username.':'.$data->software_certification_id,
            $data->password,
            $data->pmcc_number,
            $request->ticket_number
        );

        $decryptor = new PhilHealthEClaimsEncryptor();

        return XML2JSON($decryptor->decryptPayloadDataToXml($encrypted, $data->cipher_key));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
