<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibReligion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibReligionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibReligion::upsert([
            ['religion_code' => 'AGLIP', 'religion_desc' => 'Aglipay'],
            ['religion_code' => 'ALLY', 'religion_desc' => 'Alliance of Bible Christian Communities'],
            ['religion_code' => 'ANGLI', 'religion_desc' => 'Anglican'],
            ['religion_code' => 'BAPTI', 'religion_desc' => 'Baptist'],
            ['religion_code' => 'BRNAG', 'religion_desc' => 'Born Again Christian'],
            ['religion_code' => 'BUDDH', 'religion_desc' => 'Buddhism'],
            ['religion_code' => 'CATHO', 'religion_desc' => 'Catholic'],
            ['religion_code' => 'CHOG', 'religion_desc' => 'Church of God'],
            ['religion_code' => 'EVANG', 'religion_desc' => 'Evangelical'],
            ['religion_code' => 'IGNIK', 'religion_desc' => 'Iglesia ni Cristo'],
            ['religion_code' => 'JEWIT', 'religion_desc' => 'Jehovahs Witness'],
            ['religion_code' => 'LRCM', 'religion_desc' => 'Life Renewal Christian Ministry'],
            ['religion_code' => 'LUTHR', 'religion_desc' => 'Lutheran'],
            ['religion_code' => 'METOD', 'religion_desc' => 'Methodist'],
            ['religion_code' => 'MORMO', 'religion_desc' => 'LDS-Mormons'],
            ['religion_code' => 'MUSLI', 'religion_desc' => 'Islam'],
            ['religion_code' => 'PENTE', 'religion_desc' => 'Pentecostal'],
            ['religion_code' => 'PROTE', 'religion_desc' => 'Protestant'],
            ['religion_code' => 'SVDAY', 'religion_desc' => 'Seventh Day Adventist'],
            ['religion_code' => 'UCCP', 'religion_desc' => 'UCCP'],
            ['religion_code' => 'UNKNO', 'religion_desc' => 'Unknown'],
            ['religion_code' => 'WESLY', 'religion_desc' => 'Wesleyan'],
            ['religion_code' => 'XTIAN', 'religion_desc' => 'Christian'],
        ], ['religion_code']);
    }
}
