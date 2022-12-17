<?php

namespace App\Services\PhilHealth;

use App\Classes\LocalSoapClient;
use App\Classes\PhilHealthEClaimsEncryptor;
use Illuminate\Support\Facades\Http;
use Spatie\ArrayToXml\ArrayToXml;
use Str;

class SoapService
{
    private function _client()
    {
        $opts = array(
            'http' => [
                'user_agent' => 'PHPSoapClient',
                'header' => 'Token: eyJhbGciOiJIUzI1NiJ9.eyJDb2RlMSI6IkhBZzdmS3dFeUhhSExCOFZxYi9nYmciLCJDb2RlMiI6InBMb0N3eUFic0YxVkdZR045NVdZSVEiLCJDb2RlNCI6IkpMVHh2aWRQYnFjTFVsTjRyeEt2clEifQ.jtXbGX75jozvZ0qGtqAQ7qn2Ro_P9FoekYa3SmwmI04'
            ],
            'ssl' => [
                // set some SSL/TLS specific options
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        );

        $wsdlUrl = "https://ecstest.philhealth.gov.ph/KONSULTA/SOAP?wsdl";

        $context = stream_context_create($opts);
        $soapClientOptions = array(
            'location' => $wsdlUrl,
            'stream_context' => $context,
            'cache_wsdl' => WSDL_CACHE_NONE,
            'exceptions' => true,
            'keep_alive' => false
        );

        try{
            return new LocalSoapClient($wsdlUrl, $soapClientOptions);
        }catch(\Exception $e){
            $desc = $e->getMessage();
            return $desc;
        }
    }

    private function getToken()
    {
        $this->client = $this->_client(['pSoftwareCertificationId' => 'KON-DUMMYSCERTZ09634','pHospitalCode' => 'P01033020']);
        try {
          $result = $this->client->getToken(['pSoftwareCertificationId' => 'KON-DUMMYSCERTZ09634','pHospitalCode' => 'P01033020']);
          return $this->decryptResponse($result);
        }
        catch (\Exception $e) {
             return $e;       // just re-throw it
        }
    }

    private function decryptResponse($encryptedOutput)
    {
        if (!isJson($encryptedOutput->return)) {
            return $encryptedOutput;
        }

        $jsonOutput = json_decode($encryptedOutput->return);

        if(!isset($jsonOutput->hash))
        {
            return $jsonOutput;
        }

        $decryptor = new PhilHealthEClaimsEncryptor();
        //$decryptor->setLoggingEnabled(true);
        $cipher_key = 'PHilheaLthDuMmyciPHerKeyS';
        $decryptedData = $decryptor->decryptPayloadDataToXml($encryptedOutput->return, $cipher_key);
        return (XML2JSON($decryptedData));
    }

    public function soapMethod($method, $params)
    {
        //return $this->getToken();
        $this->client = $this->_client($params);
        try {
          $result = $this->client->$method($params);
          return $this->decryptResponse($result);
        }
        catch (\Exception $e) {
             return $e;       // just re-throw it
        }
    }

    public function soapCall()
    {
        $opts = array(
            'http' => [
                'user_agent' => 'PHPSoapClient',
                'header' => 'Token: eyJhbGciOiJIUzI1NiJ9.eyJDb2RlMSI6IkhBZzdmS3dFeUhhSExCOFZxYi9nYmciLCJDb2RlMiI6InBMb0N3eUFic0YxVkdZR045NVdZSVEiLCJDb2RlNCI6IkpMVHh2aWRQYnFjTFVsTjRyeEt2clEifQ.jtXbGX75jozvZ0qGtqAQ7qn2Ro_P9FoekYa3SmwmI04'
            ],
            'ssl' => [
                // set some SSL/TLS specific options
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        );

        $wsdlUrl = "https://ecstest.philhealth.gov.ph/KONSULTA/SOAP?wsdl";

        $context = stream_context_create($opts);
        $soapClientOptions = array(
            'location' => $wsdlUrl,
            'stream_context' => $context,
            'cache_wsdl' => WSDL_CACHE_NONE,
            'exceptions' => true,
            'keep_alive' => false
        );

        try{
            $client = new LocalSoapClient($wsdlUrl, $soapClientOptions);
        }catch(\Exception $e){
            $desc = $e->getMessage();
            return $desc;
        }

        $encryptedOutput = $client->extractRegistrationList(['pStartDate' => '01/01/2022', 'pEndDate' => '12/31/2022']);
        //$encryptedOutput = $client->getToken(['pSoftwareCertificationId' => 'KON-DUMMYSCERTZ09634','pHospitalCode' => 'P01033020']);
        $response = json_decode($encryptedOutput->return);

        if(isJson($encryptedOutput->return)) {
            $decryptor = new PhilHealthEClaimsEncryptor();
            //$decryptor->setLoggingEnabled(true);
            $cipher_key = 'PHilheaLthDuMmyciPHerKeyS';
            $decryptedData = $decryptor->decryptPayloadDataToXml($encryptedOutput->return, $cipher_key);
            return (XML2JSON($decryptedData));
        }

        return $encryptedOutput;
    }

    public function httpClient()
    {
        return $response = Http::post('https://ecstest.philhealth.gov.ph/KONSULTA/SOAP?wsdl');
        $wsdlUrl = "https://ecstest.philhealth.gov.ph/KONSULTA/SOAP?wsdl";
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
        $result = ArrayToXml::convert($array, [
            'rootElementName' => 'Envelope',
            '_attributes' => [
                'xmlns' => 'http://schemas.xmlsoap.org/soap/envelope/',
            ],
        ], true, 'UTF-8');

        $postArray = [
            'pSoftwareCertificationId' => 'KON-DUMMYSCERTZ09634',
            'pHospitalCode' => 'P01033020'
        ];
        return Http::post($wsdlUrl,$postArray);

        return $http=Http::withHeaders([
            'Content-Type'=>'application/xml',
            'user_agent' => 'PHPSoapClient',
            'SOAPAction'=>'balance'
        ])->post($wsdlUrl,$postArray);



        return response($http->body())
            ->withHeaders([
                'Content-Type' => 'text/xml'
            ]);
    }


}
