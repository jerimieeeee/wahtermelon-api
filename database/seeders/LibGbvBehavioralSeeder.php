<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvBehavioral;
use Illuminate\Database\Seeder;

class LibGbvBehavioralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvBehavioral::upsert([
            ['id' => 1, 'desc' => 'Depression', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Blank stares, withdrawal', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Nightmares, sleep disturbances', 'sequence' => 3],
            ['id' => 4, 'desc' => 'Loss of appetite', 'sequence' => 4],
            ['id' => 5, 'desc' => 'Suicide attempt, ideation', 'sequence' => 5],
            ['id' => 6, 'desc' => 'Truancy, problems in school', 'sequence' => 6],
            ['id' => 7, 'desc' => 'Anxiety, hyperactivity', 'sequence' => 7],
            ['id' => 8, 'desc' => 'Running away from home', 'sequence' => 8],
            ['id' => 9, 'desc' => 'Aggression, anger', 'sequence' => 9],
            ['id' => 10, 'desc' => 'Self-mutilation', 'sequence' => 10],
            ['id' => 11, 'desc' => 'Psychotic episodes', 'sequence' => 11],
            ['id' => 12, 'desc' => 'Other', 'sequence' => 12],
        ], ['id']);
    }
}
