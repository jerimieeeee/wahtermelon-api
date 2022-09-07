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
            ['status_id' => 'ANLD', 'status_code' => 'A', 'status_desc' => 'Annulled'],
            ['status_id' => 'CHBTN', 'status_code' => 'C', 'status_desc' => 'Co-Habitation'],
            ['status_id' => 'MRRD', 'status_code' => 'M', 'status_desc' => 'Married'],
            ['status_id' => 'SNGL', 'status_code' => 'S', 'status_desc' => 'Single'],
            ['status_id' => 'SPRTD', 'status_code' => 'X', 'status_desc' => 'Separated'],
            ['status_id' => 'WDWD', 'status_code' => 'W', 'status_desc' => 'Widowed'],
        ], ['status_id']);
    }
}
