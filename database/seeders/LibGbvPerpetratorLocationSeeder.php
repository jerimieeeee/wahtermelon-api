<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvPerpetratorLocation;
use Illuminate\Database\Seeder;

class LibGbvPerpetratorLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvPerpetratorLocation::upsert([
            ['id' => 1, 'desc' => 'Patient\'s household', 'sequence' => 1],
            ['id' => 2, 'desc' => 'In jail, police custody', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Residence', 'sequence' => 3],
            ['id' => 4, 'desc' => 'Other know location', 'sequence' => 4],
            ['id' => 5, 'desc' => 'Unknown', 'sequence' => 5],
        ], ['id']);
    }
}
