<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibLaboratoryResult;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibLaboratoryResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibLaboratoryResult::upsert([
            ['code' => 'P', 'desc' => 'Positive'],
            ['code' => 'N', 'desc' => 'Negative'],
        ], ['code']);
    }
}
