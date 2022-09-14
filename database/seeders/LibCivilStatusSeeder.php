<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibCivilStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibCivilStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibCivilStatus::upsert([
            ['code' => 'ANLD', 'short_code' => 'A', 'status_desc' => 'Annulled'],
            ['code' => 'CHBTN', 'short_code' => 'C', 'status_desc' => 'Co-Habitation'],
            ['code' => 'MRRD', 'short_code' => 'M', 'status_desc' => 'Married'],
            ['code' => 'SNGL', 'short_code' => 'S', 'status_desc' => 'Single'],
            ['code' => 'SPRTD', 'short_code' => 'X', 'status_desc' => 'Separated'],
            ['code' => 'WDWD', 'short_code' => 'W', 'status_desc' => 'Widowed'],
        ], ['code']);
    }
}
