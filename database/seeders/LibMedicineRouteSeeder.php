<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibMedicineRoute;
use Illuminate\Database\Seeder;

class LibMedicineRouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return vocode
     */
    public function run()
    {
        LibMedicineRoute::upsert([
            ['code' => 1, 'desc' => 'Oral'],
            ['code' => 2, 'desc' => 'Subcutaneous'],
            ['code' => 3, 'desc' => 'Intramuscular'],
            ['code' => 4, 'desc' => 'Sublingual/Buccal'],
            ['code' => 5, 'desc' => 'Topical'],
            ['code' => 6, 'desc' => 'Intravenous'],
            ['code' => 7, 'desc' => 'Rectal'],
            ['code' => 8, 'desc' => 'Vaginal'],
            ['code' => 9, 'desc' => 'Ocular'],
            ['code' => 10, 'desc' => 'Otic'],
            ['code' => 11, 'desc' => 'Nasal'],
            ['code' => 12, 'desc' => 'Inhalation'],
            ['code' => 13, 'desc' => 'Cutaneous'],
            ['code' => 14, 'desc' => 'Transdermal'],
            ['code' => 15, 'desc' => 'Intrathecal'],
            ['code' => 16, 'desc' => 'Intradermal'],
        ], ['desc']);
    }
}
