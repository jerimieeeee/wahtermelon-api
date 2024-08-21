<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibMortalityCause;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibMortalityCauseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibMortalityCause::upsert([
            ['code' => 'ANT',     'desc' => 'Antecedent Cause'],
            ['code' => 'UND',     'desc' => 'Underlying Cause'],
        ], ['code']);
    }
}
