<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvSymptomsBehavioral;
use App\Models\V1\Libraries\LibGbvSymptomsCorporal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LibGbvSymptomsBehavioralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        LibGbvSymptomsBehavioral::truncate();
        Schema::enableForeignKeyConstraints();

        LibGbvSymptomsBehavioral::upsert([
            ['desc' => 'Depression',                           'sequence' => 1],
            ['desc' => 'Blank stares, Withdrawal',             'sequence' => 2],
            ['desc' => 'Nightmares, sleep disturbances',       'sequence' => 3],
            ['desc' => 'Loss of appetite',                     'sequence' => 4],
            ['desc' => 'Suicide attempt, ideation',            'sequence' => 5],
            ['desc' => 'Truancy, problems at school',          'sequence' => 6],
            ['desc' => 'Anxiety, hyperactivity',               'sequence' => 7],
            ['desc' => 'Running away from home',               'sequence' => 8],
            ['desc' => 'Aggression, anger',                    'sequence' => 9],
            ['desc' => 'Self-mutilation',                      'sequence' => 10],
            ['desc' => 'Psychotic episodes',                   'sequence' => 11],
            ['desc' => 'Other',                                'sequence' => 12],
        ], ['id']);
    }
}
