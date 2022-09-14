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
            ['code' => 'AGLIP', 'religion_desc' => 'Aglipay'],
            ['code' => 'ALLY', 'religion_desc' => 'Alliance of Bible Christian Communities'],
            ['code' => 'ANGLI', 'religion_desc' => 'Anglican'],
            ['code' => 'BAPTI', 'religion_desc' => 'Baptist'],
            ['code' => 'BRNAG', 'religion_desc' => 'Born Again Christian'],
            ['code' => 'BUDDH', 'religion_desc' => 'Buddhism'],
            ['code' => 'CATHO', 'religion_desc' => 'Catholic'],
            ['code' => 'CHOG', 'religion_desc' => 'Church of God'],
            ['code' => 'EVANG', 'religion_desc' => 'Evangelical'],
            ['code' => 'IGNIK', 'religion_desc' => 'Iglesia ni Cristo'],
            ['code' => 'JEWIT', 'religion_desc' => 'Jehovahs Witness'],
            ['code' => 'LRCM', 'religion_desc' => 'Life Renewal Christian Ministry'],
            ['code' => 'LUTHR', 'religion_desc' => 'Lutheran'],
            ['code' => 'METOD', 'religion_desc' => 'Methodist'],
            ['code' => 'MORMO', 'religion_desc' => 'LDS-Mormons'],
            ['code' => 'MUSLI', 'religion_desc' => 'Islam'],
            ['code' => 'PENTE', 'religion_desc' => 'Pentecostal'],
            ['code' => 'PROTE', 'religion_desc' => 'Protestant'],
            ['code' => 'SVDAY', 'religion_desc' => 'Seventh Day Adventist'],
            ['code' => 'UCCP', 'religion_desc' => 'UCCP'],
            ['code' => 'UNKNO', 'religion_desc' => 'Unknown'],
            ['code' => 'WESLY', 'religion_desc' => 'Wesleyan'],
            ['code' => 'XTIAN', 'religion_desc' => 'Christian'],
        ], ['code']);
    }
}
