<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibPtGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LibPtGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        LibPtGroup::truncate();
        Schema::enableForeignKeyConstraints();

        LibPtGroup::upsert([
            ['id' => 'cn',  'desc' => 'Consultation'],
            ['id' => 'mc',  'desc' => 'Maternal Care'],
            ['id' => 'tb',  'desc' => 'TB Dots'],
            ['id' => 'cc',  'desc' => 'Child Care'],
            ['id' => 'ab',  'desc' => 'Animal Bite'],
            ['id' => 'ncd', 'desc' => 'Non-communicable disease'],
            ['id' => 'cv',  'desc' => 'COVID-19'],
            ['id' => 'dn',  'desc' => 'Dental'],
            ['id' => 'mh',  'desc' => 'Mental Health'],
            ['id' => 'lp',  'desc' => 'Leprosy'],
            ['id' => 'ml',  'desc' => 'Malaria'],
            ['id' => 'fp',  'desc' => 'Family Planning'],
            ['id' => 'at',  'desc' => 'Adolescent'],
            ['id' => 'gbv',  'desc' => 'Gender Based Violence'],
            ['id' => 'asrh',  'desc' => 'Adolescent Sexual and Reproductive Health'],
        ], ['id']);
    }
}
