<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibBloodType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibBloodTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibBloodType::upsert([
            ['code' => 'A-', 'sequence' => 1],
            ['code' => 'A+', 'sequence' => 2],
            ['code' => 'AB-', 'sequence' => 3],
            ['code' => 'AB+', 'sequence' => 4],
            ['code' => 'B-', 'sequence' => 5],
            ['code' => 'B+', 'sequence' => 6],
            ['code' => 'O-', 'sequence' => 7],
            ['code' => 'O+', 'sequence' => 8],
            ['code' => 'NA', 'sequence' => 0],
        ], ['code']);
    }
}
