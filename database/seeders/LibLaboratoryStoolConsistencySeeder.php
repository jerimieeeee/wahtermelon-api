<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibLaboratoryStoolConsistency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibLaboratoryStoolConsistencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibLaboratoryStoolConsistency::upsert([
            ['code' => '1', 'desc' => 'Soft'],
            ['code' => '2', 'desc' => 'Well-Formed'],
            ['code' => '3', 'desc' => 'Semi-Formed'],
            ['code' => '4', 'desc' => 'Watery'],
            ['code' => '5', 'desc' => 'Mucoid'],
            ['code' => '6', 'desc' => 'Hard'],
        ], ['code']);
    }
}
