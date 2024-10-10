<?php

namespace App\Jobs;

use App\Classes\PhilHealthEClaimsEncryptor;
use App\Models\V1\Eclaims\EclaimsUpload;
use App\Models\V1\PhilHealth\PhilhealthCredential;
use App\Services\PhilHealth\SoapService;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EclaimsStatusJob implements ShouldQueue, ShouldBeUniqueUntilProcessing
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;
    protected $claim;
    public $timeout = 1000;
    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $retryAfter = 60;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(EclaimsUpload $claim)
    {
        $this->claim = $claim;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(SoapService $service)
    {
        $program_code = $this->claim->program_desc == 'cc' || $this->claim->program_desc == 'fp' ? 'mc' : $this->claim->program_desc;
        $credentials = PhilhealthCredential::whereFacilityCode($this->claim->facility_code)->whereProgramCode($program_code)->first();

        $encrypted = $service->_client('GetClaimStatus', [
            $credentials->username . ':' . $credentials->software_certification_id,
            $credentials->password,
            $credentials->pmcc_number,
            $this->claim->pClaimSeriesLhio,
        ], true);

        $decryptor = new PhilHealthEClaimsEncryptor();
        $status = XML2JSON($decryptor->decryptPayloadDataToXml($encrypted, $credentials->cipher_key));

        if(isset($status) && is_object($status)) {
            if(isset($status->CLAIM)) {
                switch ($status->CLAIM->pStatus) {
                    case "RETURN":
                        $this->claim->update(['pStatus' => $status->CLAIM->pStatus, 'return_reason' => is_object($status->CLAIM->RETURN->DEFECTS) ? json_encode($status->CLAIM->RETURN->DEFECTS) : $status->CLAIM->RETURN->DEFECTS]);
                        break;
                    case "DENIED":
                        if(isset($status->CLAIM->DENIED) && is_array($status->CLAIM->DENIED->REASON)) {
                            $deniedReason = $status->CLAIM->DENIED->REASON;
                        } elseif (isset($status->CLAIM->DENIED) && !is_array($status->CLAIM->DENIED->REASON)) {
                            $deniedReason = $status->CLAIM->DENIED->REASON->pReason;
                        } else {
                            $deniedReason = null;
                        }
                        $this->claim->update(['pStatus' => $status->CLAIM->pStatus, 'denied_reason' => $deniedReason]);
                        break;
                    default:
                        $this->claim->update(['pStatus' => $status->CLAIM->pStatus]);
                        break;
                }
            }
        }
        // Process the status as needed

    }
}
