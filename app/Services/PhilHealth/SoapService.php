<?php

namespace App\Services\PhilHealth;

use App\Classes\LocalSoapClient;
use App\Classes\PhilHealthEClaimsEncryptor;
use Str;

class SoapService
{
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

        if(isJson($encryptedOutput->return)) {
            $decryptor = new PhilHealthEClaimsEncryptor();
            //$decryptor->setLoggingEnabled(true);
            $cipher_key = 'PHilheaLthDuMmyciPHerKeyS';
            $decryptedData = $decryptor->decryptPayloadDataToXml($encryptedOutput->return, $cipher_key);
            return (XML2JSON($decryptedData));
        }

        return $encryptedOutput;
    }


}
