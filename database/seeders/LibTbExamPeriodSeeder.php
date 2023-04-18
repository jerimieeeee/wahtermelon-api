<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibTbExamPeriod;
use Illuminate\Database\Seeder;

class LibTbExamPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibTbExamPeriod::upsert([
            ['id' => 1, 'desc' => 'Before Treatment'],
            ['id' => 2, 'desc' => '2nd Week'],
            ['id' => 3, 'desc' => '1st Month'],
            ['id' => 4, 'desc' => '2nd Month'],
            ['id' => 5, 'desc' => '3rd Month'],
            ['id' => 6, 'desc' => '4th Month'],
            ['id' => 7, 'desc' => '5th Month'],
            ['id' => 8, 'desc' => '6th Month'],
            ['id' => 9, 'desc' => '7th Month'],
            ['id' => 10, 'desc' => '8th Month'],
            ['id' => 11, 'desc' => '9th Month'],
            ['id' => 12, 'desc' => '10th Month'],
        ], ['id']);
    }
}
