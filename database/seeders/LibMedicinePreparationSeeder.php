<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibMedicinePreparation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibMedicinePreparationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibMedicinePreparation::upsert([
            ['code' => 'AMP', 'desc' => 'Ampule'],
            ['code' => 'BOT', 'desc' => 'Bottle'],
            ['code' => 'BPACK', 'desc' => 'Blister pack'],
            ['code' => 'CAP', 'desc' => 'Capsule'],
            ['code' => 'NEB', 'desc' => 'Nebule'],
            ['code' => 'SACH', 'desc' => 'Sachet'],
            ['code' => 'SUSP', 'desc' => 'Suspension'],
            ['code' => 'TAB', 'desc' => 'Tablet'],
            ['code' => 'VIAL', 'desc' => 'Vial']
        ], ['code']);
    }
}
