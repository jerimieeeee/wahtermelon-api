<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibOccupationCategory;
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
            ['code' => 'AGRI', 'category_desc' => 'Agriculture'],
            ['code' => 'EDUC', 'category_desc' => 'Education'],
            ['code' => 'FOOD', 'category_desc' => 'Industry'],
            ['code' => 'GOVT', 'category_desc' => 'Government'],
            ['code' => 'HEALTH', 'category_desc' => 'Health'],
            ['code' => 'MAR', 'category_desc' => 'Maritime'],
            ['code' => 'MFG', 'category_desc' => 'Manufacturing'],
            ['code' => 'RETL', 'category_desc' => 'Retail'],
            ['code' => 'SVC', 'category_desc' => 'Service'],
            ['code' => 'TOUR', 'category_desc' => 'Tourism'],
            ['code' => 'TRANS', 'category_desc' => 'Transport'],
            ['code' => 'UNSP', 'category_desc' => 'Unspecified'],
        ], ['category_desc']);
    }
}
