<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvMentalAge;
use Illuminate\Database\Seeder;

class LibGbvMentalAgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvMentalAge::upsert([
            ['id' => 1, 'desc' => 'Child', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Adult', 'sequence' => 2],
        ], ['id']);
    }
}
