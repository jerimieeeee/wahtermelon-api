<?php

namespace App\Classes;

use Illuminate\Support\Facades\Log;

class LocalSoapClient extends \SoapClient
{
    private $maxRetries;
    private $retryDelay;

    public function __construct($wsdl, $options = [], $maxRetries = 50, $retryDelay = 1)
    {
        $this->maxRetries = $maxRetries;
        $this->retryDelay = $retryDelay;
        parent::__construct($wsdl, $options);
    }

    public function __call($function_name, $arguments)
    {
        $result = false;
        $retry_count = 0;

        while (! $result && $retry_count < $this->maxRetries) {
            try {
                $result = parent::__call($function_name, $arguments);
            } catch (\SoapFault $fault) {
                if ($fault->faultstring != 'Could not connect to host') {
                    throw $fault;
                }
                Log::warning("SOAP retry #{$retry_count} for method {$function_name}: {$fault->faultstring}");
            }
            sleep($this->retryDelay);
            $retry_count++;
        }

        if ($retry_count == $this->maxRetries) {
            Log::error("SOAP method {$function_name} failed after {$this->maxRetries} attempts");
            throw new \SoapFault('Client', "Could not connect to host after {$this->maxRetries} attempts");
        }

        return $result;
    }
}
