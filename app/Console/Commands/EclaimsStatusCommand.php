<?php

namespace App\Console\Commands;

use App\Classes\PhilHealthEClaimsEncryptor;
use App\Jobs\EclaimsStatusJob;
use App\Models\V1\Eclaims\EclaimsUpload;
use App\Models\V1\PhilHealth\PhilhealthCredential;
use App\Services\PhilHealth\SoapService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class EclaimsStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eclaims:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process Eclaims status updates and queue the requests';

    /**
     * Execute the console command.
     */
    public function handle(SoapService $service)
    {
//        $eclaims = EclaimsUpload::query()->whereIn('pStatus', ['IN PROCESS', 'VOUCHERING', 'WITH VOUCHER'])->whereNotNull('pClaimSeriesLhio')->get();
////        $eclaims = EclaimsUpload::query()->whereIn('pStatus', ['IN PROCESS'])->where('pClaimSeriesLhio', '240329070065607')->get();
//
//        foreach ($eclaims as $claim) {
//            $program_code = $claim->program_desc == 'cc' || $claim->program_desc == 'fp' ? 'mc' : $claim->program_desc;
//            $credentials = PhilhealthCredential::whereFacilityCode($claim->facility_code)->whereProgramCode($program_code)->first();
//            //dd($credentials);
//            //dd($claim->pClaimSeriesLhio);
//            $encrypted = $service->_client('GetClaimStatus', [
//                $credentials->username.':'.$credentials->software_certification_id,
//                $credentials->password,
//                $credentials->pmcc_number,
//                $claim->pClaimSeriesLhio,
//            ], true);
//            $decryptor = new PhilHealthEClaimsEncryptor();
//            $status = XML2JSON($decryptor->decryptPayloadDataToXml($encrypted, $credentials->cipher_key));
//            //print_r($status);
//            //dd(isJson(isset($status->CLAIM) && is_object($status->CLAIM) ? get_object_vars($status->CLAIM) : $status));
//
//        }
        /*$eclaims = EclaimsUpload::query()
            ->whereIn('pStatus', ['IN PROCESS', 'VOUCHERING', 'WITH VOUCHER'])
            ->whereNotNull('pClaimSeriesLhio')
            ->limit(10)
            ->get();

        $batchJobs = [];
        foreach ($eclaims as $claim) {
            $batchJobs[] = EclaimsStatusJob::dispatch($claim);
        }
        // Dispatch the jobs in a batch
        Bus::batch($batchJobs)->dispatch();*/
//        Bus::batch([])->then(function () {
//            // Batch completion callback
//        })->catch(function () {
//            // Handle failed jobs
//        })->finally(function () {
//            // Batch finish callback
//        });

        EclaimsUpload::query()
            ->whereIn('pStatus', ['IN PROCESS', 'VOUCHERING', 'WITH VOUCHER'])
            ->whereNotNull('pClaimSeriesLhio')
            //->where('pClaimSeriesLhio','240401070294507')
            //->where('pClaimSeriesLhio','240404070172907')
            ->chunk(100, function ($eclaims) {
                $jobs = $eclaims->map(function ($claim) {
                    return new EclaimsStatusJob($claim);
                })->toArray();

                $batch = Bus::batch($jobs)
                    ->name('Eclaims Status Batch')
                    ->dispatch();

                $this->info("Batch ID: {$batch->id} dispatched successfully.");
            });
    }

}
