<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibPregnancyDeliveryType;
use Illuminate\Database\Seeder;

class LibPregnancyDeliveryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibPregnancyDeliveryType::upsert([
            ['code' => 'N', 'desc' => 'Normal (NSD)'],
            ['code' => 'O', 'desc' => 'Operative (CSD)'],
            ['code' => 'B', 'desc' => 'Both Normal & Operative (NSD & CSD)'],
            ['code' => 'X', 'desc' => 'Not Applicable'],
        ], ['code']);
    }
}
