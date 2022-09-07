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
            ['education_id' => 1, 'education_desc' => 'Elementary Education'],
            ['education_id' => 2, 'education_desc' => 'High School Education'],
            ['education_id' => 3, 'education_desc' => 'College'],
            ['education_id' => 4, 'education_desc' => 'Postgraduate Program'],
            ['education_id' => 5, 'education_desc' => 'No Formal Education - No Schooling'],
            ['education_id' => 6, 'education_desc' => 'Not Applicable'],
            ['education_id' => 7, 'education_desc' => 'Vocational'],
            ['education_id' => 8, 'education_desc' => 'Others'],
        ], ['education_desc']);
    }
}
