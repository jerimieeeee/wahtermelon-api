<?php

namespace App\Http\Controllers\API\V1\Konsulta;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\PhilHealth\GetTokenResource;
use App\Models\V1\PhilHealth\PhilhealthCredential;
use App\Services\PhilHealth\KonsultaService;
use App\Services\PhilHealth\SoapService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\ArrayToXml\ArrayToXml;

/**
 * @authenticated
 * @group Konsulta Information
 *
 * APIs for managing Konsulta Information
 * @subgroup Konsulta
 * @subgroupDescription Konsulta.
 */
class KonsultaController extends Controller
{
    public function index(SoapService $service, KonsultaService $konsultaService)
    {
        //return $service->soapMethod('extractRegistrationList', ['pStartDate' => '12/09/2022', 'pEndDate' => '12/31/2022']);
        $firstTranche = $konsultaService->generateXml();
        $data = $service->encryptData($firstTranche);
        return $service->soapMethod('validateReport', ['pReport' => $data, 'pReportTagging' =>1]);
        /*$credentials = PhilhealthCredential::whereProgramCode('kp')->first();
        $credentialsResource = GetTokenResource::make($credentials)->resolve();
        $arr = [$credentialsResource,$credentialsResource];
        $array = [
            'Body' => [
                'getToken' => [
                    '_attributes' => [
                        'xmlns' => 'http://philhealth.gov.ph/'
                    ],
                    'pUserName' => '',
                    'pUserPassword' => '',
                    'pSoftwareCertificationId' => [
                        '_attributes' => [
                            'xmlns' => '',
                        ],
                        '_value' => 'KON-DUMMYSCERTZ09634'
                    ],
                    'pHospitalCode' => [
                        '_attributes' => [
                            'xmlns' => '',
                        ],
                        '_value' => 'P01033020',
                    ]
                ],
            ],
        ];
        foreach($arr as $key => $value){
            $array["enlistment"]["sample"][$key] = ['_attributes' => $value];
        }
        //$array["enlistment"]["sample"] = $arr;
        $result = new ArrayToXml($array, [
            'rootElementName' => 'PCB',
            '_attributes' => $credentialsResource,
        ]);
        return $result->dropXmlDeclaration()->toXml();*/
        //$credentials = GetTokenResource::make(PhilhealthCredential::whereProgramCode('kp')->first())->resolve();
        //return [ $credentials->toArray()];
        //return $service->soapMethod('isATCValid', ['pPIN' => '190269297550', 'pATC' => '190269297550', 'pEffectivityDate' => '12/31/2022']);
        //return $service->soapMethod('isMemberDependentRegistered', ['pPIN' => '190269297550', 'pType' => 'MM']);
       /* return $service->soapMethod('getToken', $credentials);
        return $service->soapMethod('extractRegistrationList', ['pStartDate' => '12/09/2022', 'pEndDate' => '12/31/2022']);
        return $service->httpClient();
        return $service->soapCall();*/
    }

    /**
     * getToken
     *
     * @param SoapService $service
     * @return Exception|mixed
     */
    public function getToken(SoapService $service): mixed
    {
        $credentials = PhilhealthCredential::whereProgramCode('kp')->first();
        $credentialsResource = GetTokenResource::make($credentials)->resolve();
        $result = $service->soapMethod('getToken', $credentialsResource);
        if($result->success) {
            $credentials->update(['token' => $result->result]);
            return response()->json([
                'message' => 'Successfully added the token in the database!'
            ], 201);
        }
        return response()->json($result, 200);;
    }

    /**
     * extractRegistrationList
     *
     * @queryParam pStartDate date Start date format mm/dd/YYYY. Example: 01/01/2022
     * @queryParam pEndDate date End date format mm/dd/YYYY. Example: 12/31/2022
     * @param Request $request
     * @param SoapService $service
     * @return Exception|mixed
     */
    public function extractRegistrationList(Request $request, SoapService $service): mixed
    {
        return $service->soapMethod('extractRegistrationList', $request->only('pStartDate', 'pEndDate'));
    }

    /**
     * isMemberDependentRegistered
     *
     * @queryParam pPIN string Patient PIN. Example: 0123456789123
     * @queryParam pType string Type. Example: MM
     * @param Request $request
     * @param SoapService $service
     * @return Exception|mixed
     */
    public function checkRegistered(Request $request, SoapService $service): mixed
    {
        return $service->soapMethod('isMemberDependentRegistered', $request->only('pPIN', 'pType'));
    }

    /**
     * isATCValid
     *
     * @queryParam pPIN string Patient PIN. Example: 0123456789123
     * @queryParam pATC string Type. Example: abcdefghij
     * @queryParam pEffectivityDate date End date format mm/dd/YYYY. Example: 01/01/2022
     * @param Request $request
     * @param SoapService $service
     * @return Exception|mixed
     */
    public function checkATC(Request $request, SoapService $service): mixed
    {
        return $service->soapMethod('isATCValid', $request->only('pPIN', 'pATC', 'pEffectivityDate'));
    }

    public function validateReport(SoapService $service, KonsultaService $konsultaService)
    {
        $firstTranche = $konsultaService->generateXml();
        $data = $service->encryptData($firstTranche);
        return $service->soapMethod('validateReport', ['pReport' => $data, 'pReportTagging' =>1]);
    }
}
