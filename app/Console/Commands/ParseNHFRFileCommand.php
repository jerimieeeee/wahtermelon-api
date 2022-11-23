<?php

namespace App\Console\Commands;

use App\Models\V1\PSGC\Facility;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\SimpleExcel\SimpleExcelReader;

class ParseNHFRFileCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nhfr:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse National Health Facility Registry';

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
            $this->truncateTables();
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

    private function performTask($properties)
    {
        $data = [
            'code'                          => $properties['Health Facility Code'],
            'short_code'                    => $properties['Health Facility Code Short'],
            'facility_name'                 => $properties['Facility Name'],
            'old_facility_name_1'           => !empty(trim($properties['Old Health Facility Name 1'])) ? $properties['Old Health Facility Name 1'] : null,
            'old_facility_name_2'           => !empty(trim($properties['Old Health Facility Name 2'])) ? $properties['Old Health Facility Name 2'] : null,
            'old_facility_name_3'           => !empty(trim($properties['Old Health Facility Name 3'])) ? $properties['Old Health Facility Name 3'] : null,
            'facility_major_type'           => !empty(trim($properties["Facility Major Type"])) ? $properties["Facility Major Type"] : null,
            'health_facility_type'          => !empty(trim($properties["Health Facility Type"])) ? $properties["Health Facility Type"] : null,
            'ownership_classification'      => $properties["Ownership Major Classification"],
            'ownership_sub_classification'  => $properties["Ownership Major Classification"] == 'Government' ? $properties["Ownership Sub-Classification for Government facilities"] : $properties["Ownership Sub-Classification for private facilities"],
            'region_code'                     => $properties["Region PSGC"],
            'province_code'                   => $properties["Province PSGC"],
            'municipality_code'               => $properties["City/Municipality PSGC"],
            'barangay_code'                   => $properties["Barangay PSGC"],
            'service_capability'            => $properties["Service Capability"],
            'bed_capacity'                  => intval(str_replace(",","",$properties["Bed Capacity"])),
        ];

        $data = array_filter($data);

        $data['region_code'] = $this->processPSGC($data, 'region_code', $properties["Region Name"]);
        $data['province_code'] = $this->processPSGC($data, 'province_code', $properties["Province Name"]);
        $data['municipality_code'] = $this->processPSGC($data, 'municipality_code', $properties["City/Municipality Name"]);
        $data['barangay_code'] = $this->processPSGC($data, 'barangay_code', $properties["Barangay Name"]);

        $this->processData($data);
    }

    private function processPSGC($data, $label, $location)
    {
        if(!isset($data[$label])) {
            return;
        }
        $data[$label] = (Str::length($data[$label]) == 8 ? '0'.$data[$label] : Str::length($data[$label]) == 7) ? $data[$label].'0' : $data[$label];
        if ($data[$label] == '099700000') {
            $data[$label] = '098300000';
        }
        if ($data[$label] == '129800000') {
            $data[$label] = '153800000';
        }
        if (str_starts_with($data[$label], '18')){
            switch ($label) {
                case 'region_code' && str_starts_with($data['province_code'], '1845'):
                case 'province_code' && str_starts_with($data['province_code'], '1845'):
                case 'municipality_code' && str_starts_with($data['municipality_code'], '1845'):
                case 'barangay_code' && str_starts_with($data['barangay_code'], '1845'):
                    $data[$label] = Str::replaceFirst('18', '06', $data[$label]);
                    break;
                case 'region_code' && str_starts_with($data['province_code'], '1846'):
                case 'province_code' && str_starts_with($data['province_code'], '1846'):
                case 'municipality_code' && str_starts_with($data['municipality_code'], '1846'):
                case 'barangay_code' && str_starts_with($data['barangay_code'], '1846'):
                    $data[$label] = Str::replaceFirst('18', '07', $data[$label]);
                    break;
                default:
                    break;
            }
        }

        //$modelName = Str::ucfirst(substr($label, 0, strpos($label, "_")));
        //$modelName = '\\App\\Models\\V1\\PSGC\\'.$modelName;
        //$id = $modelName::select('id')->whereCode($data[$label])->pluck('id')->first();
        //return $id;
        return $data[$label]?? null;
    }

    private function processData($data)
    {
        Facility::create($data);
    }

    private function truncateTables()
    {
        Schema::disableForeignKeyConstraints();
        Facility::truncate();
        Schema::enableForeignKeyConstraints();
    }
}
