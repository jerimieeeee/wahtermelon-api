<?php

namespace App\Console\Commands;

use App\Models\V1\PSGC\Barangay;
use App\Models\V1\PSGC\City;
use App\Models\V1\PSGC\District;
use App\Models\V1\PSGC\Municipality;
use App\Models\V1\PSGC\Province;
use App\Models\V1\PSGC\Region;
use App\Models\V1\PSGC\SubMunicipality;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Exception;
use Spatie\SimpleExcel\SimpleExcelReader;

class ParsePSGCFileCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'psgc:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse PSGC Publication';

    protected $latest = '';

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

    private function truncateTables()
    {
        Schema::disableForeignKeyConstraints();
        Region::truncate();
        Province::truncate();
        District::truncate();
        Municipality::truncate();
        City::truncate();
        SubMunicipality::truncate();
        Barangay::truncate();
        Schema::enableForeignKeyConstraints();
    }

    private function performTask($properties)
    {
        $data = [
            'code'                  => $properties['Code'],
            'psgc_10_digit_code'    => $properties['10-digit PSGC'],
            'name'                  => $properties['Name'],
            'level'                 => $properties['Geographic Level'],
            'geo_level'             => $properties['Geographic Level'],
            'city_class'            => $properties['City Class'],
            'income_class'          => $properties["Income\nClassification"],
            'urban_rural'           => $properties["Urban / Rural\n(based on 2015 Population)"],
            'population'            => preg_replace('/\D+/', '', $properties["2020 Population"]),
        ];

        $data = array_filter($data);

        if (isset($data['level']) && $data['level'] != 'SGU') {
            $data['level'] = match ($data['level']) {
                'Dist' => 'Prov',
                'City', 'SubMun' => 'Mun',
                default => $data['level'],
            };
            $methods = 'process'.$data['level'];

            $this->$methods($data);
        }
    }

    private function processReg($data)
    {
        Region::create($data);

        $this->latest = Region::class;
    }

    private function processProv($data)
    {
        $data['region_id'] = Region::orderBy('id', 'desc')->pluck('id')->first();
        Province::create($data);

        $this->latest = Province::class;
    }

    private function processDist($data)
    {
        $data['region_id'] = Region::orderBy('id', 'desc')->pluck('id')->first();
        District::create($data);

        $this->latest = District::class;
    }

    private function processCity($data)
    {
        $region   = Region::orderBy('id', 'desc')->first();
        $province = Province::orderBy('id', 'desc')->first();
        $district = District::orderBy('id', 'desc')->first();

        $geographic = optional($district)->created_at > optional($province)->created_at ? $district : $province;

        // 099701000 &x 129804000
        if (in_array($data['code'], ['099701000', '129804000'])) {
            $geographic = $region;
        }

        $data['geographic_type'] = get_class($geographic);
        $data['geographic_id'] = $geographic->id;
        City::create($data);

        $this->latest = City::class;
    }

    private function processSubMun($data)
    {
        $data['city_id'] = City::orderBy('id', 'desc')->pluck('id')->first();
        SubMunicipality::create($data);

        $this->latest = SubMunicipality::class;
    }

    private function processMun($data)
    {
        $geographic = Province::orderBy('id', 'desc')->first();

        /*if (in_array($data['code'], ['137606000'])) {
            $geographic = District::orderBy('id', 'desc')->first();
        }*/

        $data['geographic_type'] = get_class($geographic);
        $data['geographic_id'] = $geographic->id;

        Municipality::create($data);

        $this->latest = Municipality::class;
    }

    private function processBgy($data)
    {
        $latest = $this->latest;

        $geographic = (new $latest())->orderBy('id', 'desc')->first();

        $data['geographic_type'] = get_class($geographic);
        $data['geographic_id'] = $geographic->id;
        Barangay::create($data);
    }

}
