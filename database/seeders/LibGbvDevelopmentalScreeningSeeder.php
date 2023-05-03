<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvDevelopmentalScreening;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibGbvDevelopmentalScreeningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvDevelopmentalScreening::upsert([
            ['id' => 1, 'desc' => 'Probable development delay (for age below 7)', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Probable learning problems (for school-aged)', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Physical disabilities', 'sequence' => 3],
            ['id' => 4, 'desc' => 'Sensory impairment', 'sequence' => 4],
            ['id' => 5, 'desc' => 'Neglected schooling', 'sequence' => 5],
            ['id' => 6, 'desc' => 'Probable moderate to profound mental retardation', 'sequence' => 6],
            ['id' => 7, 'desc' => 'Other', 'sequence' => 7],
        ], ['id']);
    }
}
