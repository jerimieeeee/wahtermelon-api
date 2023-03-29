<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibLaboratoryFindings;
use Illuminate\Database\Seeder;

class LibLaboratoryFindingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibLaboratoryFindings::upsert([
            ['code' => '1', 'desc' => 'Essentially Normal'],
            ['code' => '2', 'desc' => 'With Findings'],
        ], ['code']);
    }
}
