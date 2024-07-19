<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibMortalityDeathType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibMortalityDeathTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibMortalityDeathType::upsert([
            ['code' => 'MRTLY',     'desc' => 'Mortality'], // all population
            ['code' => 'MATD',     'desc' => 'Maternal Mortality'], // pregnant women
            ['code' => 'NEOD',    'desc' => 'Neonatal Mortality'], // 0 to 28 Days old
            ['code' => 'INFD',   'desc' => 'Infant Mortality'], // 29 Days old to 11 Months old
            ['code' => 'UDFD',    'desc' => 'Under-Five Mortality'], // 1 to 4 Years old or 12 to 59 Months old
            ['code' => 'ENEOD',    'desc' => 'Early Neonatal Mortality'], // Fetal deaths and early neonatal deaths 0 to 6 days old
        ], ['code']);
    }
}
