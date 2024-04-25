<?php

namespace App\Services\PhilHealth;

use App\Classes\LocalSoapClient;
use App\Classes\PhilHealthEClaimsEncryptor;
use App\Http\Resources\API\V1\PhilHealth\GetTokenResource;
use App\Models\V1\Konsulta\KonsultaRegistrationList;
use App\Models\V1\PhilHealth\PhilhealthCredential;
use App\Services\Eclaims\EclaimsSyncService;
use Illuminate\Support\Facades\Http;
use Spatie\ArrayToXml\ArrayToXml;
use Str;

class SoapService
{
    public function _client($methodName = null, $args = null)
    {
        ini_set('max_execution_time', 0);
        $opts = [
            'http' => [
                'user_agent' => 'PHPSoapClient'
            ],
            'ssl' => [
                // set some SSL/TLS specific options
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ];

        if (isset(request()->program_code) && request()->program_code !== 'kp') {
            $eclaimsSyncService = new EclaimsSyncService();
            return $eclaimsSyncService->checkEclaimsUrl($methodName, $args);
        } else {
            $token = auth()->user()->konsultaCredential->token;
            $opts['http']['header'] = "Token: $token";
            $wsdlUrl = config('app.konsulta_url');
        }

//        if (! isset(request()->program_code) && request()->program_code !== 'kp') {
//            $token = auth()->user()->konsultaCredential->token;
//            $opts['http']['header'] = "Token: $token";
//            $wsdlUrl = config('app.konsulta_url');
//        } else {
//            $eclaimsSyncService = new EclaimsSyncService();
//            $onlineUrls = $eclaimsSyncService->checkEclaimsUrl();
//            $wsdlUrl = $onlineUrls[0];
//        }

//        if (isset(request()->program_code) && request()->program_code !== 'kp') {
//            $eclaimsSyncService = new EclaimsSyncService();
//            $onlineUrls = $eclaimsSyncService->checkEclaimsUrl();
//            $wsdlUrl = $onlineUrls[0];
//        } else {
//            $token = auth()->user()->konsultaCredential->token;
//            $opts['http']['header'] = "Token: $token";
//            $wsdlUrl = config('app.konsulta_url');
//        }

//        if (! isset(request()->program_code) && request()->program_code != 'kp') {
//            //$token = PhilhealthCredential::select('token')->whereProgramCode('kp')->pluck('token')->first();
//            $token = auth()->user()->konsultaCredential->token;
//
//            $opts['http']['header'] = "Token: $token";
//
//            //$wsdlUrl = 'https://ecstest.philhealth.gov.ph/KONSULTA/SOAP?wsdl';
//            $wsdlUrl = config('app.konsulta_url');
//
//        } else {
//            $eclaimsSyncService = new EclaimsSyncService();
//
//            $onlineUrls = $eclaimsSyncService->checkEclaimsUrl();
//
//            $wsdlUrl = $onlineUrls[0];
//            //$wsdlUrl = $onlineUrls;
//        }

        $context = stream_context_create($opts);
        $soapClientOptions = [
            'location' => $wsdlUrl,
            'stream_context' => $context,
            'cache_wsdl' => WSDL_CACHE_NONE,
            'exceptions' => true,
            'keep_alive' => false,
        ];

        try {
            return new LocalSoapClient($wsdlUrl, $soapClientOptions);
        } catch (\SoapFault|\Exception $e) {
            $desc = $e->getMessage();

            return $desc;
        }
    }

    /*private function decryptResponse($encryptedOutput)
    {
        if (isset($encryptedOutput->return) && ! isJson($encryptedOutput->return)) {
            if (Str::contains($encryptedOutput->return, ['Please enter Valid', 'Token', 'token'])) {
                $credentials = auth()->user()->konsultaCredential;
                $credentialsResource = GetTokenResource::make($credentials)->resolve();
                $result = $this->soapMethod('getToken', $credentialsResource);
                if (isset($result->success)) {
                    $result = (array) $result;
                    $credentials->update(['token' => $result['result']]);

                    return response()->json([
                        'message' => 'Successfully added the token in the database! You may now use konsulta webservice.',
                    ], 201);
                }
            }

            return $encryptedOutput;
        }
        if (isset($encryptedOutput->return)) {
            if (property_exists($encryptedOutput, 'return') && strpos($encryptedOutput->return, 'java.net.SocketException') !== false) {
                // The object has "return" property containing "java.net.SocketException"
                // Do something here, like logging or handling the exception
                throw new \Exception($encryptedOutput->return, 503);
            }
            $jsonOutput = json_decode($encryptedOutput->return);
            $cipher_key = auth()->user()->konsultaCredential->cipher_key;
        } else {
            $jsonOutput = json_decode($encryptedOutput);
            $data = PhilhealthCredential::whereProgramCode(request()->program_code)->first();

            $cipher_key = $data->cipher_key;
        }
        $decryptor = new PhilHealthEClaimsEncryptor();
        //$cipher_key = PhilhealthCredential::select('cipher_key')->whereProgramCode('kp')->pluck('cipher_key')->first();

        if (! isset($jsonOutput->hash)) {
            if (isset($jsonOutput->encryptedxmlerrors)) {
                $decryptedData = $decryptor->decryptPayloadDataToXml(json_encode($jsonOutput->encryptedxmlerrors), $cipher_key);

                return json_decode($decryptedData);
            }
            if (isset($jsonOutput->uploadxmlresult) && isset($jsonOutput->uploadxmlresult->errors)) {
                return json_decode($jsonOutput->uploadxmlresult->errors);
            }
            if (isset($jsonOutput->iv)) {
                $decryptedData = $decryptor->decryptPayloadDataToXml(json_encode($jsonOutput), $cipher_key);

                return XML2JSON($decryptedData);
            }

            return $jsonOutput;
        }

        $decryptedData = $decryptor->decryptPayloadDataToXml($encryptedOutput->return, $cipher_key);

        return XML2JSON($decryptedData);
    }*/

    private function decryptResponse($encryptedOutput)
    {
        // Check if the output is a SOAP fault
        if ($encryptedOutput instanceof SoapFault) {
            $faultcode = $encryptedOutput->faultcode;
            $faultstring = $encryptedOutput->faultstring;

            // Ensure $faultcode is an integer
            $faultcode = is_numeric($faultcode) ? (int) $faultcode : 500;

            // Return SOAP fault details as error response
            return response()->json(
                [
                    'code' => $faultcode,
                    'message' => $faultstring . " PhilHealth Server cannot handle the request (because it is overloaded or down for maintenance). Please try again."
                ]
            , $faultcode);
        }

        if (property_exists($encryptedOutput, 'return') && strpos($encryptedOutput->return, 'java.net.SocketException') !== false) {
            $faultcode = 503;
            $faultstring = $encryptedOutput->return;

            // Return SocketException details as error response
            return response()->json(
                [
                    'code' => $faultcode,
                    'message' => $faultstring . " PhilHealth Server cannot handle the request (because it is overloaded or down for maintenance). Please try again."
                ]
            , 503);
        }

        // Extract the encrypted return value
        $encryptedReturn = property_exists($encryptedOutput, 'return') ? $encryptedOutput->return : $encryptedOutput;

        // Check if the return value is JSON
        if (! isJson($encryptedReturn)) {
            if (Str::contains($encryptedReturn, ['Please enter Valid', 'Token', 'token'])) {
                // Handle token-related errors
                $result = $this->handleTokenError();

                // If token addition is successful, return success response
                if (isset($result['success'])) {
                    return response()->json([
                        'message' => 'Successfully added the token in the database! You may now use konsulta webservice.',
                    ], 201);
                }
            }

            // Return the original encrypted output
            return $encryptedOutput;
        }

        // Decode the JSON return value
        $jsonOutput = json_decode($encryptedReturn);

        // Get the cipher key based on the context
        $cipher_key = isset($encryptedOutput->return) ? auth()->user()->konsultaCredential->cipher_key : PhilhealthCredential::whereProgramCode(request()->program_code)->first()->cipher_key;

        // Create an instance of the decryptor
        $decryptor = new PhilHealthEClaimsEncryptor();

        // Decrypt the data and return the result
        return $this->handleDecryption($jsonOutput, $decryptor, $cipher_key, $encryptedOutput);
    }

    private function handleTokenError()
    {
        $credentials = auth()->user()->konsultaCredential;
        $credentialsResource = GetTokenResource::make($credentials)->resolve();
        $result = $this->soapMethod('getToken', $credentialsResource);

        if (isset($result->success)) {
            $result = (array) $result;
            $credentials->update(['token' => $result['result']]);
            return ['success' => true];
        }

        return ['success' => false];
    }

    private function handleDecryption($jsonOutput, $decryptor, $cipher_key, $encryptedOutput)
    {
        if (! isset($jsonOutput->hash)) {
            if (isset($jsonOutput->encryptedxmlerrors)) {
                $decryptedData = $decryptor->decryptPayloadDataToXml(json_encode($jsonOutput->encryptedxmlerrors), $cipher_key);
                return json_decode($decryptedData);
            }
            if (isset($jsonOutput->uploadxmlresult) && isset($jsonOutput->uploadxmlresult->errors)) {
                return json_decode($jsonOutput->uploadxmlresult->errors);
            }
            if (isset($jsonOutput->iv)) {
                $decryptedData = $decryptor->decryptPayloadDataToXml(json_encode($jsonOutput), $cipher_key);
                return XML2JSON($decryptedData);
            }
            return $jsonOutput;
        }

        $decryptedData = $decryptor->decryptPayloadDataToXml($encryptedOutput->return, $cipher_key);
        return XML2JSON($decryptedData);
    }

    public function encryptData($data, $cipher_key = null, $mimeType = null)
    {
        $encryptor = new PhilHealthEClaimsEncryptor();
        //$cipher_key = PhilhealthCredential::select('cipher_key')->whereProgramCode('kp')->pluck('cipher_key')->first();
        $cipher_key = $cipher_key ?? auth()->user()->konsultaCredential->cipher_key;

        return $encryptor->encryptXmlPayloadData($data, $cipher_key, $mimeType);
    }

    public function soapMethod1($method, $params)
    {
        //return $this->getToken();
        $this->client = $this->_client();
        /*try {
            $result = $this->client->$method($params);

            return $this->decryptResponse($result);
        } catch (\SoapFault|\Exception $e) {
            // Handle SOAP faults
            // Return SOAP fault with error details
            $faultcode = $e->faultcode;
            $faultstring = $e->getMessage();

            $response = new \SoapFault($faultcode, $faultstring);
            // Return the SOAP fault as a response
            return $response;
        }*/
        try {
            // Call the SOAP method
            $result = $this->client->$method($params);

            // If the result is a SOAP fault, handle it
            if ($result instanceof SoapFault) {
                // Extract fault details
                $faultcode = $result->faultcode;
                $faultstring = $result->faultstring . " PhilHealth Server cannot handle the request (because it is overloaded or down for maintenance). Please try again.";

                // Ensure $faultcode is an integer
                $faultcode = is_numeric($faultcode) ? (int) $faultcode : 500;

                // Return error response
                return response()->json(
                    [
                        'code' => $faultcode,
                        'message' => $faultstring
                    ]
                , $faultcode); // Set appropriate HTTP status code for server error
            }

            // If result is not a SOAP fault, decrypt and return response
            return $this->decryptResponse($result);
        } catch (\SoapFault $e) {
            // Handle SOAP faults that were not caught by the SoapClient
            $faultcode = $e->faultcode;
            $faultstring = $e->getMessage();

            // Ensure $faultcode is an integer
            $faultcode = is_numeric($faultcode) ? (int) $faultcode : 500;

            // Return error response
            return response()->json(
                [
                    'code' => $faultcode,
                    'message' => $faultstring
                ]
            , $faultcode); // Set appropriate HTTP status code for server error
        }
    }

    public function soapMethod($method, $params)
    {
        $this->client = $this->_client();
        // Use Laravel's retry function to attempt the SOAP method call with retries
        return retry(5, function () use ($method, $params) {
            // Call the SOAP method
            $result = $this->client->$method($params);

            // If the result is a SOAP fault, handle it
            if ($result instanceof SoapFault) {
                // Extract fault details
                $faultcode = $result->faultcode;
                $faultstring = $result->faultstring . " PhilHealth Server cannot handle the request (because it is overloaded or down for maintenance). Please try again.";

                // Ensure $faultcode is an integer
                $faultcode = is_numeric($faultcode) ? (int) $faultcode : 500;

                // Return error response
                return response()->json(
                    [
                        'code' => $faultcode,
                        'message' => $faultstring
                    ]
                , $faultcode); // Set appropriate HTTP status code for server error
            }

            // If result is not a SOAP fault, decrypt and return response
            return $this->decryptResponse($result);
        }, 1000);
    }


    public function saveRegistrationList(array $data)
    {
        $newArray = [];
        foreach ($data as $key => $value) {
            $newArray[$key]['facility_code'] = auth()->user()->facility_code;
            $newArray[$key]['user_id'] = auth()->id();
            $newArray[$key]['custom_id'] = auth()->user()->facility_code.$value->pAssignedPin.$value->pEffYear;
            $newArray[$key]['philhealth_id'] = $value->pAssignedPin;
            $newArray[$key]['last_name'] = $value->pAssignedLastName;
            $newArray[$key]['first_name'] = $value->pAssignedFirstName;
            $newArray[$key]['middle_name'] = $value->pAssignedMiddleName;
            $newArray[$key]['suffix_name'] = $value->pAssignedExtName;
            $newArray[$key]['birthdate'] = ! empty($value->pAssignedDateOfBirth) ? $value->pAssignedDateOfBirth : null;
            $newArray[$key]['gender'] = $value->pAssignedSex;
            $newArray[$key]['membership_type_id'] = $value->pAssignedType;
            $newArray[$key]['member_pin'] = $value->pPrimaryPIN;
            $newArray[$key]['member_last_name'] = $value->pPrimaryLastName;
            $newArray[$key]['member_first_name'] = $value->pPrimaryFirstName;
            $newArray[$key]['member_middle_name'] = $value->pPrimaryMiddleName;
            $newArray[$key]['member_suffix_name'] = $value->pPrimaryExtName;
            $newArray[$key]['member_birthdate'] = ! empty($value->pPrimaryDateOfBirth) ? $value->pPrimaryDateOfBirth : null;
            $newArray[$key]['member_gender'] = $value->pPrimarySex;
            $newArray[$key]['mobile_number'] = Str::remove(' ', $value->pMobileNumber);
            $newArray[$key]['landline_number'] = Str::remove(' ', $value->pLandlineNumber);
            $newArray[$key]['member_category'] = $value->pMemberNewCat;
            $newArray[$key]['member_category_desc'] = $value->pMemberNewCatDesc;
            $newArray[$key]['package_type_id'] = $value->pPackageType;
            $newArray[$key]['assigned_date'] = $value->pAssignedDate;
            $newArray[$key]['assigned_status_id'] = $value->pAssignedStatus;
            $newArray[$key]['effectivity_year'] = $value->pEffYear;
            /*$data[$key] = array_change_key_case($value, CASE_LOWER,
                [
                    "pAssignedPin" => "philhealth_id",
                    "pAssignedLastName" => "last_name",
                    "pAssignedFirstName" => "first_name",
                    "pAssignedMiddleName" => "middle_name",
                    "pAssignedExtName" => "suffix_name",
                    "pAssignedDateOfBirth" => "birthdate",
                    "pAssignedSex" => "gender",
                    "pAssignedType" => "membership_type_id",
                    "pPrimaryPIN" => "member_pin",
                    "pPrimaryLastName" => "member_last_name",
                    "pPrimaryFirstName" => "member_first_name",
                    "pPrimaryMiddleName" => "member_middle_name",
                    "pPrimaryExtName" => "member_suffix_name",
                    "pPrimaryDateOfBirth" => "member_birthdate",
                    "pPrimarySex" => "member_gender",
                    "pMobileNumber" => "mobile_number",
                    "pLandlineNumber" => "landline_number",
                    "pMemberNewCat" => "member_category",
                    "pMemberNewCatDesc" => "member_category_desc",
                    "pPackageType" => "package_type_id",
                    "pAssignedDate" => "assigned_date",
                    "pAssignedStatus" => "assigned_status_id",
                    "pEffYear" => "effectivity_year"
                ]);*/
        }
        $chunkSize = 200; // Define the desired chunk size
        $chunks = collect($newArray)->chunk($chunkSize);
        $model = new KonsultaRegistrationList(); // Replace "YourModel" with your actual model name

        $chunks->each(function ($chunk) use ($model) {
            $values = [];
            //$updateColumns = ['value']; // Define the columns to update if a conflict occurs

            foreach ($chunk as $record) {
                $values[] = $record;
            }

            $model->upsert($values, ['custom_id']);
        });
        //KonsultaRegistrationList::upsert($newArray, ['custom_id']);
    }

    public function httpClient()
    {
        //return $response = Http::post('https://ecstest.philhealth.gov.ph/KONSULTA/SOAP?wsdl');
        $wsdlUrl = 'https://ecstest.philhealth.gov.ph/KONSULTA/SOAP?wsdl';
        $array = [
            'Body' => [
                'getToken' => [
                    '_attributes' => [
                        'xmlns' => 'http://philhealth.gov.ph/',
                    ],
                    'pUserName' => '',
                    'pUserPassword' => '',
                    'pSoftwareCertificationId' => [
                        '_attributes' => [
                            'xmlns' => '',
                        ],
                        '_value' => 'KON-DUMMYSCERTZ09634',
                    ],
                    'pHospitalCode' => [
                        '_attributes' => [
                            'xmlns' => '',
                        ],
                        '_value' => 'P01033020',
                    ],
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
            'pUserName' => '',
            'pUserPassword' => '',
            'pSoftwareCertificationId' => 'KON-DUMMYSCERTZ09634',
            'pHospitalCode' => 'P01033020',
        ];
        //return Http::post($wsdlUrl,$postArray);

        $http = Http::withHeaders([
            'Content-Type' => 'text/xml; charset=utf-8',
            'SOAPAction' => 'getToken',
        ])->post($wsdlUrl, $postArray);

        return $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'SOAPAction' => 'getToken',
        ])->post(
            $wsdlUrl,
            $postArray
        );

        return $http->getBody();

        return response($http->body())
            ->withHeaders([
                'Content-Type' => 'text/xml',
            ]);
    }
}
