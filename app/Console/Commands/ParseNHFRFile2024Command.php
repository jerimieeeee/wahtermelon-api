<?php

namespace App\Console\Commands;

use App\Http\Resources\API\V1\PSGC\BarangayResource;
use App\Models\V1\PSGC\Barangay;
use App\Models\V1\PSGC\Facility;
use App\Models\V1\PSGC\Municipality;
use App\Models\V1\PSGC\Province;
use Illuminate\Console\Command;
use Illuminate\Database\Query\JoinClause;
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
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

    private function performTask($properties)
    {
        $data = [
            'code' => $properties['Health Facility Code'],
            'short_code' => $properties['Health Facility Code Short'],
            'facility_name' => html_entity_decode($properties['Facility Name']),
            'old_facility_name_1' => ! empty(trim($properties['Old Health Facility Name 1'])) ? html_entity_decode($properties['Old Health Facility Name 1']) : null,
            'old_facility_name_2' => ! empty(trim($properties['Old Health Facility Name 2'])) ? html_entity_decode($properties['Old Health Facility Name 2']) : null,
            'old_facility_name_3' => ! empty(trim($properties['Old Health Facility Name 3'])) ? html_entity_decode($properties['Old Health Facility Name 3']) : null,
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
            switch ($data['barangay_code']) {
                case '1380300003':
                    $data['barangay_code'] = '1381500029';
                    break;
                case '1380300004':
                    $data['barangay_code'] = '1381500030';
                    break;
                case '1380300007':
                    $data['barangay_code'] = '1381500031';
                    break;
                case '1380300016':
                    $data['barangay_code'] = '1381500032';
                    break;
                case '1380300019':
                    $data['barangay_code'] = '1381500033';
                    break;
                case '1380300028':
                    $data['barangay_code'] = '1381500037';
                    break;
                case '1380300032':
                    $data['barangay_code'] = '1381500038';
                    break;
                case '1380300033':
                    $data['barangay_code'] = '1381500036';
                    break;
                case '0803738024':
                case '0803738027':
                    $data['barangay_code'] = '0803738116';
                    break;
                case '0803738031':
                case '0803738033':
                case '0803738035':
                case '0803738039':
                    $data['barangay_code'] = '0803738117';
                    break;
                case '0402103001':
                case '0402103003':
                case '0402103022':
                    $data['barangay_code'] = '0402103089';
                    break;
                case '0402103030':
                case '0402103002':
                    $data['barangay_code'] = '0402103076';
                    break;
                case '0402103006':
                    $data['barangay_code'] = '0402103078';
                    break;
                case '0402103035':
                case '0402103010':
                    $data['barangay_code'] = '0402103079';
                    break;
                case '0402103038':
                case '0402103037':
                case '0402103011':
                    $data['barangay_code'] = '0402103080';
                    break;
                case '0402103052':
                case '0402103051':
                case '0402103015':
                    $data['barangay_code'] = '0402103083';
                    break;
                case '0402103060':
                case '0402103019':
                    $data['barangay_code'] = '0402103087';
                    break;
                case '0402103023':
                    $data['barangay_code'] = '0402103086';
                    break;
                case '0402103072':
                case '0402103025':
                    $data['barangay_code'] = '0402103092';
                    break;
                case '0402103031':
                case '0402103029':
                    $data['barangay_code'] = '0402103077';
                    break;
                case '0402103040':
                case '0402103039':
                    $data['barangay_code'] = '0402103081';
                    break;
                case '0402103044':
                    $data['barangay_code'] = '0402103082';
                    break;
                case '0402103054':
                    $data['barangay_code'] = '0402103055';
                    break;
                case '0402103056':
                    $data['barangay_code'] = '0402103058';
                    break;
                case '0402103057':
                    $data['barangay_code'] = '0402103059';
                    break;
                case '0402103063':
                case '0402103062':
                case '0402103061':
                    $data['barangay_code'] = '0402103088';
                    break;
                case '0402103070':
                case '0402103068':
                    $data['barangay_code'] = '0402103091';
                    break;
                case '0402103074':
                case '0402103073':
                    $data['barangay_code'] = '0402103093';
                    break;
                case '1999908003':
                    $data['barangay_code'] = '1999904007';
                    break;
                case '1999906008':
                    $data['barangay_code'] = '1999908010';
                    break;
            }
            $municipality = Municipality::query()
                ->select('municipalities.id', 'municipalities.psgc_10_digit_code AS municipality_code', 'provinces.psgc_10_digit_code AS province_code', 'regions.psgc_10_digit_code AS region_code')
                ->join('provinces', 'provinces.id', '=', 'municipalities.geographic_id')
                ->join('regions', 'regions.id', '=', 'provinces.region_id');
            $barangay = Barangay::query()
                ->select('psgc_10_digit_code AS barangay_code', 'municipality_code', 'province_code', 'region_code')
                ->joinSub($municipality, 'municipality', function (JoinClause $join) {
                    $join->on('barangays.geographic_id', '=', 'municipality.id');
                })
                ->where('barangays.psgc_10_digit_code', $data['barangay_code'])
                ->first();
            if(!$barangay) {
                $barangayCode = substr($data['barangay_code'], 0, 2) . substr($data['barangay_code'], 3);
                $barangay = Barangay::query()
                ->select('psgc_10_digit_code AS barangay_code', 'municipality_code', 'province_code', 'region_code')
                ->joinSub($municipality, 'municipality', function (JoinClause $join) {
                    $join->on('barangays.geographic_id', '=', 'municipality.id');
                })
                ->where('barangays.code', $barangayCode)
                ->first();
                //dd('Barangay not found: ' . $modifiedValue);
            }

            if(!isset($barangay->region_code)) {
                dd($data['barangay_code']);
            }
            $data['region_code'] = $barangay->region_code;
            $data['province_code'] = $barangay->province_code;
            $data['municipality_code'] = $barangay->municipality_code;
            $data['barangay_code'] = $barangay->barangay_code;
        } else {
            $municipality = Municipality::query()
                ->select('municipalities.id', 'municipalities.psgc_10_digit_code AS municipality_code', 'provinces.psgc_10_digit_code AS province_code', 'regions.psgc_10_digit_code AS region_code')
                ->join('provinces', 'provinces.id', '=', 'municipalities.geographic_id')
                ->join('regions', 'regions.id', '=', 'provinces.region_id')
                ->where('municipalities.psgc_10_digit_code', $data['municipality_code'])
                ->first();
            if(!isset($municipality->region_code)) {
                dd($data['municipality_code']);
            }
            $data['region_code'] = $municipality->region_code;
            $data['province_code'] = $municipality->province_code;
            $data['municipality_code'] = $municipality->municipality_code;
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
