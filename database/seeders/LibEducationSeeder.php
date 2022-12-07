<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibEducation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibEducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibEducation::upsert([
            ['code' => 1, 'education_desc' => 'Elementary Education'],
            ['code' => 2, 'education_desc' => 'High School Education'],
            ['code' => 3, 'education_desc' => 'College'],
            ['code' => 4, 'education_desc' => 'Postgraduate Program'],
            ['code' => 5, 'education_desc' => 'No Formal Education - No Schooling'],
            ['code' => 6, 'education_desc' => 'Not Applicable'],
            ['code' => 7, 'education_desc' => 'Vocational'],
            ['code' => 8, 'education_desc' => 'Others'],
        ], ['education_desc']);
    }
}
