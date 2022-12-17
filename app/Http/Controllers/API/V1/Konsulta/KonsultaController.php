<?php

namespace App\Http\Controllers\API\V1\Konsulta;

use App\Http\Controllers\Controller;
use App\Services\PhilHealth\SoapService;
use Illuminate\Http\Request;

class KonsultaController extends Controller
{
    public function index(SoapService $service)
    {
        //return $service->soapMethod('isATCValid', ['pPIN' => '190269297550', 'pATC' => '190269297550', 'pEffectivityDate' => '12/31/2022']);
        //return $service->soapMethod('isMemberDependentRegistered', ['pPIN' => '190269297550', 'pType' => 'MM']);
        //return $service->soapMethod('getToken', ['pSoftwareCertificationId' => 'KON-DUMMYSCERTZ09634', 'pHospitalCode' => 'P01033020']);
        return $service->soapMethod('extractRegistrationList', ['pStartDate' => '01/01/2022', 'pEndDate' => '12/31/2022']);
        return $service->httpClient();
        return $service->soapCall();
    }
}
