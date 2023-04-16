<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibPregnancyHistoryAnswer;
use Illuminate\Database\Seeder;

class LibPregnancyHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibPregnancyHistoryAnswer::upsert([
            ['code' => 'Y', 'desc' => 'Yes'],
            ['code' => 'N', 'desc' => 'No/None'],
        ], ['code']);
    }
}
