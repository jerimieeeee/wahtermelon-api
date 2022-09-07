<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibOccupationCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibOccupationCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibOccupationCategory::upsert([
            ['category_code' => 'AGRI', 'category_desc' => 'Agriculture'],
            ['category_code' => 'EDUC', 'category_desc' => 'Education'],
            ['category_code' => 'FOOD', 'category_desc' => 'Industry'],
            ['category_code' => 'GOVT', 'category_desc' => 'Government'],
            ['category_code' => 'HEALTH', 'category_desc' => 'Health'],
            ['category_code' => 'MAR', 'category_desc' => 'Maritime'],
            ['category_code' => 'MFG', 'category_desc' => 'Manufacturing'],
            ['category_code' => 'RETL', 'category_desc' => 'Retail'],
            ['category_code' => 'SVC', 'category_desc' => 'Service'],
            ['category_code' => 'TOUR', 'category_desc' => 'Tourism'],
            ['category_code' => 'TRANS', 'category_desc' => 'Transport'],
            ['category_code' => 'UNSP', 'category_desc' => 'Unspecified']
        ], ['category_desc']);
    }
}
