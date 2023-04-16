<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibPhilhealthPackageType;
use Illuminate\Database\Seeder;

class LibPhilhealthPackageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibPhilhealthPackageType::upsert([
            ['id' => 'P', 'desc' => 'PCB1'],
            ['id' => 'E', 'desc' => 'Expanded PCB'],
            ['id' => 'K', 'desc' => 'KONSULTA package'],
        ], ['id']);
    }
}
