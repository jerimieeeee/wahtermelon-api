<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvGeneralSurvey;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LibGbvGeneralSurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        LibGbvGeneralSurvey::truncate();
        Schema::enableForeignKeyConstraints();

        LibGbvGeneralSurvey::upsert([
            ['desc' => 'Normal',                    'sequence' => 1],
            ['desc' => 'Abnormal',                  'sequence' => 2],
            ['desc' => 'Stunting',                  'sequence' => 3],
            ['desc' => 'Wasting',                   'sequence' => 4],
            ['desc' => 'Dirty, Unkempt',            'sequence' => 5],
            ['desc' => 'Stuporous',                 'sequence' => 6],
            ['desc' => 'Pale',                      'sequence' => 7],
            ['desc' => 'Non-ambulant',              'sequence' => 8],
            ['desc' => 'Drowsy, Irritable',         'sequence' => 9],
            ['desc' => 'Respiratory Distress',      'sequence' => 10],
            ['desc' => 'Other Abnormality',         'sequence' => 11],
        ], ['id']);
    }
}
