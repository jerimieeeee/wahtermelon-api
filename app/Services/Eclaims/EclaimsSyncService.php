<?php

namespace App\Services\Eclaims;

use App\Classes\LocalSoapClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class EclaimsSyncService
{
    public function checkEclaimsUrl($methodName, $args)
    {
        $opts = [
            'http' => [
                'user_agent' => 'PHPSoapClient',
            ],
            'ssl' => [
                // set some SSL/TLS specific options
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ];

        $onlineUrls = [
            'https://eclaimslive.philhealth.gov.ph:8077/SOAP',
            'https://eclaimslive1.philhealth.gov.ph:8077/SOAP',
            'https://eclaimslive2.philhealth.gov.ph:8077/SOAP',
            'https://eclaimslive3.philhealth.gov.ph:8077/SOAP',
            'https://eclaimslive4.philhealth.gov.ph:8077/SOAP',
            'https://eclaimslive5.philhealth.gov.ph:8077/SOAP',
        ];

        $timeout = 60;
        $result = null;
        shuffle($onlineUrls);
        foreach ($onlineUrls as $url) {
            try {
                $opts['http']['timeout'] = $timeout;
                $soapClientOptions = [
                    'location' => $url,
                    'stream_context' => stream_context_create($opts),
                    'cache_wsdl' => WSDL_CACHE_DISK,
                    'exceptions' => true,
                    'keep_alive' => true,
                    'connection_timeout' => 120,
                ];

                $client = new LocalSoapClient($url, $soapClientOptions);
                $result = $client->__soapCall($methodName, $args);

                // If the CheckWS method is called successfully, set the selected URL and break the loop.
                if ($result) {
                    return $result;
                }
                break;
            } catch (\SoapFault | \Exception $e) {
                // Handle the exception if needed, or continue to the next URL.
                if($e->getCode() !== 0) {
                    throw $e;
                }
            }
        }

        if ($result !== null) {
            return $result;
        } else {
            throw new \Exception("Having problem connecting to philhealth server, please try again later");
        }
    }
}
