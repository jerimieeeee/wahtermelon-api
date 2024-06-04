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
            ['id' => 1, 'desc' => 'Sugar Sweetened Beverages/Food Drinker/Eater',   'column_name' => 'sweet_flag',          'sequence' => 1],
            ['id' => 2, 'desc' => 'Tabacco User',                                   'column_name' => 'tabacco_flag',        'sequence' => 2],
            ['id' => 3, 'desc' => 'Alcohol Drinker',                                'column_name' => 'alcohol_flag',        'sequence' => 3],
            ['id' => 4, 'desc' => 'Betel Nut Chewer',                               'column_name' => 'nut_flag',            'sequence' => 4],
            ['id' => 5, 'desc' => 'Others',                                         'column_name' => 'social_others_flag',  'sequence' => 5],
        ], ['id']);
    }
}
