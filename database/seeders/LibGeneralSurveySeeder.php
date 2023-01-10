<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGeneralSurvey;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibGeneralSurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibGeneralSurvey::upsert([
            ['code' => '1', 'desc' => 'Awake and Alert'],
            ['code' => '2', 'desc' => 'Altered Sensorium'],
        ], ['code']);
    }
}
