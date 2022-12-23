<?php

namespace App\Services\PhilHealth;

use App\Classes\LocalSoapClient;
use App\Classes\PhilHealthEClaimsEncryptor;
use App\Models\V1\PhilHealth\PhilhealthCredential;
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
            ],
            'ssl' => [
                // set some SSL/TLS specific options
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        );

        $token = PhilhealthCredential::select('token')->whereProgramCode('kp')->pluck('token')->first();

        $opts['http']['header'] = "Token: $token";

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

    private function decryptResponse($encryptedOutput)
    {
        if (!isJson($encryptedOutput->return)) {
            return $encryptedOutput;
        }

        $jsonOutput = json_decode($encryptedOutput->return);
        $decryptor = new PhilHealthEClaimsEncryptor();
        $cipher_key = PhilhealthCredential::select('cipher_key')->whereProgramCode('kp')->pluck('cipher_key')->first();

        if(!isset($jsonOutput->hash))
        {
            if(isset($jsonOutput->encryptedxmlerrors))
            {
                $decryptedData = $decryptor->decryptPayloadDataToXml(json_encode($jsonOutput->encryptedxmlerrors), $cipher_key);
                return json_decode($decryptedData);
            }
            if(isset($jsonOutput->uploadxmlresult) && isset($jsonOutput->uploadxmlresult->errors))
            {
                    return json_decode($jsonOutput->uploadxmlresult->errors);
            }
            return $jsonOutput;
        }

        $decryptedData = $decryptor->decryptPayloadDataToXml($encryptedOutput->return, $cipher_key);
        return XML2JSON($decryptedData);
    }

    public function encryptData($data)
    {
        $encryptor = new PhilHealthEClaimsEncryptor();
        $cipher_key = PhilhealthCredential::select('cipher_key')->whereProgramCode('kp')->pluck('cipher_key')->first();
        return $encryptor->encryptXmlPayloadData($data, $cipher_key);
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
