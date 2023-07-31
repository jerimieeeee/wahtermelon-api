<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibAbIndicationOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibAbIndicationOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibAbIndicationOption::upsert([
            ['code' => 'HRDC',      'desc' => 'HIGH-RISK-DOG CATCHER', 'sequence' => 1],
            ['code' => 'HRHCP',     'desc' => 'HIGH-RISK-HEALTH CARE PROVIDER', 'sequence' => 2],
            ['code' => 'HRVACC',    'desc' => 'HIGH-RISK-VACCINATOR', 'sequence' => 3],
            ['code' => 'HRVET',     'desc' => 'HIGH-RISK-VETERINARIAN', 'sequence' => 4],
            ['code' => 'HRVS',      'desc' => 'HIGH-RISK-VETERINARY STUDENT', 'sequence' => 5],
            ['code' => 'PSHRA',     'desc' => 'PRE-SCHOOL IN HIGH RISK AREAS', 'sequence' => 6],
            ['code' => 'OTHERS',    'desc' => 'OTHERS', 'sequence' => 7],
        ], ['code']);
    }
}
