<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvConferenceRecommendation;
use Illuminate\Database\Seeder;

class LibGbvConferenceRecommendationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvConferenceRecommendation::upsert([
            ['id' => 1, 'desc' => 'Remove child from home', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Home visit', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Med follow-up', 'sequence' => 3],
            ['id' => 4, 'desc' => 'Reinterview', 'sequence' => 4],
            ['id' => 5, 'desc' => 'Refer batter spouse', 'sequence' => 5],
            ['id' => 6, 'desc' => 'Drug rehabilitation', 'sequence' => 6],
            ['id' => 7, 'desc' => 'Psychotherapy for child', 'sequence' => 7],
            ['id' => 8, 'desc' => 'Therapy for parent(s)', 'sequence' => 8],
            ['id' => 9, 'desc' => 'Endorse case to', 'sequence' => 9],
            ['id' => 10, 'desc' => 'Others', 'sequence' => 10],
        ], ['id']);
    }
}
