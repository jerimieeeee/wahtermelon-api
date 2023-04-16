<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibMedicineDurationFrequency;
use Illuminate\Database\Seeder;

class LibMedicineDurationFrequencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibMedicineDurationFrequency::upsert([
            ['code' => 'D', 'desc' => 'Day', 'sequence' => 1],
            ['code' => 'W', 'desc' => 'Week', 'sequence' => 2],
            ['code' => 'M', 'desc' => 'Month', 'sequence' => 3],
            ['code' => 'Q', 'desc' => 'Quarter', 'sequence' => 4],
            ['code' => 'Y', 'desc' => 'Year', 'sequence' => 5],
            ['code' => 'I', 'desc' => 'Indefinite', 'sequence' => 6],
            ['code' => 'O', 'desc' => 'Others', 'sequence' => 7],
        ], ['code']);
    }
}
