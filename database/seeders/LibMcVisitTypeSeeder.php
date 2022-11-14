<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibMcVisitType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibMcVisitTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibMcVisitType::upsert([
            ['code' => 'CLINIC', 'desc' => 'Clinic Visit'],
            ['code' => 'HOME', 'desc' => 'Home Visit'],
        ], ['code']);
    }
}
