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

class ParsePSGCJsonFileCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'psgc-json:parse';

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
        $file = file_get_contents(storage_path('psgc-31032022.json'));
        $json = json_decode($file);

        foreach ($json as $key => $properties) {
            $data = [
                'code' => $properties->code,
                'psgc_10_digit_code' => $properties->psgc10DigitCode,
                'name' => $properties->name,
                'level' => $properties->geographicLevel,
                'city_class' => $properties->cityClass,
                'income_class' => $properties->incomeClassification,
                'urban_rural' => $properties->urbanRural,
            ];

            $data = array_filter($data);

            if (isset($data['level']) && $data['level'] != 'SGU') {
                $methods = 'process'.$data['level'];

                $this->$methods($data);
            }
        }

        return 0;
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
        $region = Region::orderBy('id', 'desc')->first();
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

        if (in_array($data['code'], ['137606000'])) {
            $geographic = District::orderBy('id', 'desc')->first();
        }

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
