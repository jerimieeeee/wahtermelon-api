<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibLaboratorySyphilisTestMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibLaboratorySyphilisTestMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibLaboratorySyphilisTestMethod::upsert([
            ['code' => '1', 'desc' => 'Rapid Plasma Reagin (RPR)'],
            ['code' => '2', 'desc' => 'Immunochromatographic Test'],
        ], ['code']);
    }
}
