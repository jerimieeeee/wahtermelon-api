<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibAbCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibAbCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibAbCategory::upsert([
            ['id' => 1, 'desc' => 'Category I', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Category II', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Category III', 'sequence' => 3],
        ], ['id']);
    }
}
