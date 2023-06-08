<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvSymptomsAnogenital;
use App\Models\V1\Libraries\LibGbvSymptomsCorporal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LibGbvSymptomsCorporalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        LibGbvSymptomsCorporal::truncate();
        Schema::enableForeignKeyConstraints();

        LibGbvSymptomsCorporal::upsert([
            ['desc' => 'Headache',                        'sequence' => 1],
            ['desc' => 'Change in Sensorium',             'sequence' => 2],
            ['desc' => 'Cough',                           'sequence' => 3],
            ['desc' => 'Nasal Discharge',                 'sequence' => 4],
            ['desc' => 'Fever',                           'sequence' => 5],
            ['desc' => 'Difficulty Breathing',            'sequence' => 6],
            ['desc' => 'Ear Pain',                        'sequence' => 7],
            ['desc' => 'Ear Discharge',                   'sequence' => 8],
            ['desc' => 'Describe Color, Odor, Amount',    'sequence' => 9],
            ['desc' => 'Skin Lesions',                    'sequence' => 10],
            ['desc' => 'Chest Pain',                      'sequence' => 11],
            ['desc' => 'Back Pain',                       'sequence' => 12],
            ['desc' => 'Limping',                         'sequence' => 13],
            ['desc' => 'Vomiting',                        'sequence' => 14],
            ['desc' => 'Describe Other Symptoms',         'sequence' => 15],
        ], ['id']);
    }
}
