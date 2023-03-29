<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibMcPregnancyTermination;
use Illuminate\Database\Seeder;

class LibMcPregnancyTerminationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibMcPregnancyTermination::upsert([
            ['code' => 'SPON', 'desc' => 'Spontaneous Abortion / Miscarriage'],
            ['code' => 'IND', 'desc' => 'Induced Abortion'],
            ['code' => 'UNK', 'desc' => 'Unknown'],
        ], ['desc']);
    }
}
