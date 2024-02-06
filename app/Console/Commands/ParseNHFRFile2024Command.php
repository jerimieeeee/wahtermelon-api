<?php

namespace App\Console\Commands;

use App\Http\Resources\API\V1\PSGC\BarangayResource;
use App\Models\V1\PSGC\Barangay;
use App\Models\V1\PSGC\Facility;
use App\Models\V1\PSGC\Municipality;
use App\Models\V1\PSGC\Province;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\SimpleExcel\SimpleExcelReader;

class ParseNHFRFile2024Command extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nhfr-2024:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse National Health Facility Registry';

    /**
     * Execute the console command.
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
            'code' => $properties['Health Facility Code'],
            'short_code' => $properties['Health Facility Code Short'],
            'facility_name' => htmlspecialchars($properties['Facility Name']),
            'old_facility_name_1' => ! empty(trim($properties['Old Health Facility Name 1'])) ? $properties['Old Health Facility Name 1'] : null,
            'old_facility_name_2' => ! empty(trim($properties['Old Health Facility Name 2'])) ? $properties['Old Health Facility Name 2'] : null,
            'old_facility_name_3' => ! empty(trim($properties['Old Health Facility Name 3'])) ? $properties['Old Health Facility Name 3'] : null,
            'facility_major_type' => ! empty(trim($properties['Facility Major Type'])) ? $properties['Facility Major Type'] : null,
            'health_facility_type' => ! empty(trim($properties['Health Facility Type'])) ? $properties['Health Facility Type'] : null,
            'ownership_classification' => $properties['Ownership Major Classification'],
            'ownership_sub_classification' => $properties['Ownership Major Classification'] == 'Government' ? $properties['Ownership Sub-Classification for Government facilities'] : $properties['Ownership Sub-Classification for private facilities'],
            'region_code' => is_string($properties['Region PSGC']) && strlen($properties['Region PSGC']) === 9 ? $properties['Region PSGC'] . '0' : $properties['Region PSGC'],
            'province_code' => is_string($properties['Province PSGC']) && strlen($properties['Province PSGC']) === 9 ? $properties['Province PSGC'] . '0' : $properties['Province PSGC'],
            'municipality_code' => is_string($properties['City/Municipality PSGC']) && strlen($properties['City/Municipality PSGC']) === 9 ? $properties['City/Municipality PSGC'] . '0' : $properties['City/Municipality PSGC'],
            'barangay_code' => is_string($properties['Barangay PSGC']) && strlen($properties['Barangay PSGC']) === 9 ? $properties['Barangay PSGC'] . '0' : $properties['Barangay PSGC'],
            'service_capability' => $properties['Service Capability'],
            'bed_capacity' => intval(str_replace(',', '', $properties['Bed Capacity'])),
        ];

        $data = array_filter($data);

        $data['region_code'] = $this->processPSGC($data, 'region_code', $properties['Region Name']);
        $data['province_code'] = $this->processPSGC($data, 'province_code', $properties['Province Name']);
        $data['municipality_code'] = $this->processPSGC($data, 'municipality_code', $properties['City/Municipality Name']);
        $data['barangay_code'] = $this->processPSGC($data, 'barangay_code', $properties['Barangay Name']);

        $this->processData($data);
    }

    private function processPSGC($data, $label, $location)
    {
        if (! isset($data[$label])) {
            return;
        }
        return ! ctype_space($data[$label]) ? $data[$label] : null;
    }

    private function processData($data)
    {
        /*if(isset($data['province_code']) && Str::of($data['province_code'])->is('13*')) {
            //$data['province_code'] = substr($data['province_code'], 0, -1);
            $data['province_code'] = Str::of($data['province_code'])->substrReplace('0', 2, 0);
        }*/
        if(isset($data['barangay_code'])) {
//            $barangay_code = Barangay::query()
//                ->addSelect(['municipality' => Municipality::select('municipalities.psgc_10_digit_code AS municipality_code', 'provinces.psgc_10_digit_code AS province_code')
//                    ->whereColumn('municipalities.id', 'barangays.geographic_id')
//                    ->join('provinces', 'provinces.id', '=' , 'municipalities.geographic_id')
//                    ->limit(1)
//                ])
//                ->where('psgc_10_digit_code',$data['barangay_code'])->first();
            $barangay_code = Barangay::query()
                ->select('psgc_10_digit_code', 'municipality_code', 'province_code') // Add other columns from the Barangay model
                ->with(['municipality' => function ($query) {
                    $query->select('municipalities.psgc_10_digit_code AS municipality_code', 'provinces.psgc_10_digit_code AS province_code')
                        ->join('provinces', 'provinces.id', '=', 'municipalities.geographic_id')
                        ->limit(1);
                }])
                ->where('psgc_10_digit_code', $data['barangay_code'])
                ->first();

            $barangay = new BarangayResource($barangay_code);
            dd($barangay_code);
        }
        Facility::create($data);
    }

    private function truncateTables()
    {
        Schema::disableForeignKeyConstraints();
        Facility::truncate();
        Schema::enableForeignKeyConstraints();
    }
}
