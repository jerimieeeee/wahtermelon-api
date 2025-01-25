<?php

namespace App\Jobs;

use App\Services\PhilHealth\SampleKonsultaService;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessKonsultaSubmissionJob implements ShouldQueue, ShouldBeUniqueUntilProcessing
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    protected $data;

    public $timeout = 10000;
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
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function uniqueId()
    {
        return md5(json_encode($this->data));
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $konsultaService = new SampleKonsultaService();

        foreach ($this->data as $patient) {
            try {
                Log::info("Processing patient ID: {$patient['patient_id']}");
                $konsultaService->createXml('', [$patient['patient_id']], 2, 1, 0, '2024');
                gc_collect_cycles();
                Log::info("Successfully processed patient ID: {$patient['patient_id']}");
            } catch (\Exception $e) {
                Log::error("Error processing patient ID: {$patient['patient_id']}, Error: {$e->getMessage()}");
            }
        }
    }
}
