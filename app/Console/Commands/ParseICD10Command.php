<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelReader;

class ParseICD10Command extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'icd10:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse ICD10 Library from PhilHealth Konsulta';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            // source: https://psa.gov.ph/classification/psgc/
            $fileName = $this->choice(
                'Please choose the file to upload',
                Storage::disk('upload')->files(),
            );
            $filePath = storage_path('uploads/'.$fileName);
            $start = now();
            $this->info("Reading $fileName file...");
            $rows = SimpleExcelReader::create($filePath)->getRows()->toArray();
            $this->info("Uploading data from $fileName to database. Please wait...");

            $this->withProgressBar($rows, function ($properties) {
                $this->performTask($properties);
            });

            $time = $start->diffAsCarbonInterval(now());
            $this->newLine();
            $this->info("Processed in $time");
        } catch (Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

    public function performTask($properties)
    {
        $data = [
            'icd10_code' => $properties['ICD Code'],
            'icd10_desc' => $properties['ICD Description'],
            'is_morbidity' => 1,
        ];
        $this->processData($data);
    }

    private function processData($data)
    {
        DB::table('lib_icd10s')->insertOrIgnore($data);
    }
}
