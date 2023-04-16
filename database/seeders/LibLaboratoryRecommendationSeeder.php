<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibLaboratoryRecommendation;
use Illuminate\Database\Seeder;

class LibLaboratoryRecommendationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibLaboratoryRecommendation::upsert([
            ['code' => 'Y', 'desc' => 'Yes', 'sequence' => 1],
            ['code' => 'N', 'desc' => 'No', 'sequence' => 2],
            ['code' => 'X', 'desc' => 'None/Not Applicable', 'sequence' => 3],
        ], ['code']);
    }
}
