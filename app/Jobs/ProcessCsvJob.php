<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelReader;

class ProcessCsvJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function handle()
    {
        $absolutePath = storage_path('app/' . $this->filePath);

        $rows = SimpleExcelReader::create($absolutePath)->getRows();

        $batch = Bus::batch([])->dispatch();

        $rows->chunk(1000)->each(function ($chunk) use ($batch) {
            $batch->add(new UploadCsvJob($chunk->toArray()));
        });

        // Delete the file after processing
        Storage::delete($this->filePath);
    }
}
