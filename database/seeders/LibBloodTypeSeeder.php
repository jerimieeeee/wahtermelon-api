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
            ['blood_type' => 'A-', 'sequence' => 1],
            ['blood_type' => 'A+', 'sequence' => 2],
            ['blood_type' => 'AB-', 'sequence' => 3],
            ['blood_type' => 'AB+', 'sequence' => 4],
            ['blood_type' => 'B-', 'sequence' => 5],
            ['blood_type' => 'B+', 'sequence' => 6],
            ['blood_type' => 'O-', 'sequence' => 7],
            ['blood_type' => 'O+', 'sequence' => 8],
            ['blood_type' => 'NA', 'sequence' => 0],
        ], ['blood_type']);
    }
}
