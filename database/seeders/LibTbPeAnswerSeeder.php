<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibTbPeAnswer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibTbPeAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibTbPeAnswer::upsert([
            ['code' => 'ND', 'desc' => 'Not done'],
            ['code' => 'NM', 'desc' => 'Normal'],
            ['code' => 'AB', 'desc' => 'Abnormal']
        ], ['code']);
    }
}
