<?php

namespace App\Services\Eclaims;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class EclaimsSyncService
{
    public function checkEclaimsUrl(): array
    {
        $urls = [
            'https://eclaimslive.philhealth.gov.ph:8077/SOAP',
            'https://eclaimslive1.philhealth.gov.ph:8077/SOAP',
            'https://eclaimslive2.philhealth.gov.ph:8077/SOAP',
            'https://eclaimslive3.philhealth.gov.ph:8077/SOAP',
            'https://eclaimslive4.philhealth.gov.ph:8077/SOAP',
            'https://eclaimslive5.philhealth.gov.ph:8077/SOAP',
        ];

        $client = new Client();

        $onlineUrls = [];

        foreach ($urls as $url) {
            try {
                $response = $client->get($url);

                if ($response->getStatusCode() === 200) {
                    $onlineUrls[] = $url;
                }
            } catch (RequestException $e) {
            }
        }

        return $onlineUrls;
    }
}
