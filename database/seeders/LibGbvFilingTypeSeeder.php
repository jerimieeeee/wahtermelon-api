<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvFilingType;
use Illuminate\Database\Seeder;

class LibGbvFilingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvFilingType::upsert([
            ['id' => 1, 'desc' => 'Inquest', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Regular Filing', 'sequence' => 2],
        ], ['id']);
    }
}
