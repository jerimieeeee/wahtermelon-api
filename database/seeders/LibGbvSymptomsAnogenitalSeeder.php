<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvSymptomsAnogenital;
use App\Models\V1\Libraries\LibWashingtonDisabilityQuestion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LibGbvSymptomsAnogenitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        LibGbvSymptomsAnogenital::truncate();
        Schema::enableForeignKeyConstraints();

        LibGbvSymptomsAnogenital::upsert([
            ['desc' => 'Abdominal pain',                        'sequence' => 1],
            ['desc' => 'Vulvar / Penile Discomfort / Pain',     'sequence' => 2],
            ['desc' => 'Dysuria',                               'sequence' => 3],
            ['desc' => 'Urinary Tract Infection',               'sequence' => 4],
            ['desc' => 'Enuresis (Day or Night) ',              'sequence' => 5],
            ['desc' => 'Genital Itching',                       'sequence' => 6],
            ['desc' => 'Genital Bleeding',                      'sequence' => 7],
            ['desc' => 'Genital Discharge',                     'sequence' => 8],
            ['desc' => 'Describe Color, Odor, Amount',          'sequence' => 9],
            ['desc' => 'Pelvic Pain',                           'sequence' => 10],
            ['desc' => 'Rectal Pain',                           'sequence' => 11],
            ['desc' => 'Rectal Bleeding',                       'sequence' => 12],
            ['desc' => 'Diarrhea',                              'sequence' => 13],
            ['desc' => 'Constipation',                          'sequence' => 14],
            ['desc' => 'Incontinent Stool, Encopresis',         'sequence' => 15],
            ['desc' => 'Pregnancy',                             'sequence' => 16],
            ['desc' => 'Amenorrhea',                            'sequence' => 17],
        ], ['id']);
    }
}
