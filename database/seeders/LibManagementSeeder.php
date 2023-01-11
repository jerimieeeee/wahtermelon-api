<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibManagement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibManagement::upsert([
            ['code' => '1', 'desc' => 'Breastfeeding Program Education'],
            ['code' => '2', 'desc' => 'Counselling for Smoking Cessation'],
            ['code' => '3', 'desc' => 'Counselling for Lifestyle Modification'],
            ['code' => '4', 'desc' => 'Oral Check-up and Prophylaxis'],
            ['code' => '0', 'desc' => 'Not applicable'],
            ['code' => 'X', 'desc' => 'Others'],
        ], ['code']);
    }
}
