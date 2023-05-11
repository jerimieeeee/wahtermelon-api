<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibAnswerYnx;
use Illuminate\Database\Seeder;

class LibAnswerYnxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibAnswerYnx::upsert([
            ['code' => 'Y', 'desc' => 'Yes'],
            ['code' => 'N', 'desc' => 'No'],
            ['code' => 'X', 'desc' => 'Unknown'],
        ], ['code']);
    }
}
