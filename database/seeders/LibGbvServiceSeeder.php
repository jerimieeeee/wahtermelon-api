<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvService;
use Illuminate\Database\Seeder;

class LibGbvServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvService::upsert([
            ['id' => 1, 'desc' => 'Full evaluation', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Physical exam', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Interview', 'sequence' => 3],
            ['id' => 4, 'desc' => 'Others', 'sequence' => 4],
        ], ['id']);
    }
}
