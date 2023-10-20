<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibDentalSocialHistory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibDentalSocialHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibDentalSocialHistory::upsert([
            ['id' => 1, 'desc' => 'Sugar Sweetened Beverages/Food Drinker/Eater', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Tabacco User', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Alcohol Drinker', 'sequence' => 3],
            ['id' => 4, 'desc' => 'Betel Nut Chewer', 'sequence' => 4],
            ['id' => 5, 'desc' => 'Others', 'sequence' => 5],
        ], ['id']);
    }
}
