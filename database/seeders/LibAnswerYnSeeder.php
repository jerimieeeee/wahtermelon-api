<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibAnswerYn;
use Illuminate\Database\Seeder;

class LibAnswerYnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibAnswerYn::upsert([
            ['code' => 'Y', 'desc' => 'Yes'],
            ['code' => 'N', 'desc' => 'No'],
        ], ['code']);
    }
}
