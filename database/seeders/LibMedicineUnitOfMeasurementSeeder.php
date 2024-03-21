<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibMedicineUnitOfMeasurement;
use Illuminate\Database\Seeder;

class LibMedicineUnitOfMeasurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibMedicineUnitOfMeasurement::upsert([
            ['code' => 'L', 'desc' => 'Liter'],
            ['code' => 'mcg', 'desc' => 'Microgram'],
            ['code' => 'mEq', 'desc' => 'Milliequivalent'],
            ['code' => 'mg', 'desc' => 'Milligram'],
            ['code' => 'mL', 'desc' => 'Milliliter'],
            ['code' => 'oz', 'desc' => 'Ounce'],
            ['code' => 'pt', 'desc' => 'Pint'],
            ['code' => 'qt', 'desc' => 'Quart'],
            ['code' => 'T, tbs', 'desc' => 'Tablespoon'],
            ['code' => 't, tsp', 'desc' => 'Teaspoon'],
            ['code' => 'IU', 'desc' => 'International Unit'],
            ['code' => 'Drops', 'desc' => 'Drops'],
        ], ['code']);
    }
}
