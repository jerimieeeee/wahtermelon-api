<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibMedicinePreparation;
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
            ['code' => 'VIAL', 'desc' => 'Vial'],
            ['code' => 'MDI', 'desc' => 'Metered Dose Inhaler'],
            ['code' => 'CRE', 'desc' => 'Cream'],
            ['code' => 'OINT', 'desc' => 'Ointment'],
            ['code' => 'CARP', 'desc' => 'Carpule'],
            ['code' => 'SOL', 'desc' => 'Solution'],
            ['code' => 'SYR', 'desc' => 'Syrup'],
            ['code' => 'LOT', 'desc' => 'Lotion'],
            ['code' => 'TUBE', 'desc' => 'Tube']
        ], ['code']);
    }
}
