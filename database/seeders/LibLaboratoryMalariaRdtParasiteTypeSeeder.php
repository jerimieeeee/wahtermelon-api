<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibLaboratoryMalariaRdtParasiteType;
use Illuminate\Database\Seeder;

class LibLaboratoryMalariaRdtParasiteTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibLaboratoryMalariaRdtParasiteType::upsert([
            ['code' => 'N', 'desc' => 'Negative'],
            ['code' => 'NMP', 'desc' => 'No Malaria Parasite'],
            ['code' => 'PF', 'desc' => 'Plasmodium Falciparum'],
            ['code' => 'PFM', 'desc' => 'Plasmodium Falciparum/Malariae'],
            ['code' => 'PFV', 'desc' => 'Plasmodium Falciparum/Vivax'],
        ], ['code']);
    }
}
