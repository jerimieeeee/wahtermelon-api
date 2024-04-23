<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibLaboratoryXrayType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibLaboratoryXrayTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibLaboratoryXrayType::upsert([
            ['code' => 'CHEST',     'desc' => 'Chest'],
            ['code' => 'SKULL',     'desc' => 'Skull'],
            ['code' => 'UPREXT',    'desc' => 'Upper Extremities'],
            ['code' => 'ABDOMEN',   'desc' => 'Abdomen'],
            ['code' => 'PELVIC',    'desc' => 'Pelvic'],
        ], ['code']);
    }
}
