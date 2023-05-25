<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvAbusedSite;
use Illuminate\Database\Seeder;

class LibGbvAbusedSiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvAbusedSite::upsert([
            ['id' => 1, 'desc' => 'Victim survivor\'s home', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Perpetrator\'s home', 'sequence' => 2],
            ['id' => 3, 'desc' => 'School', 'sequence' => 3],
            ['id' => 4, 'desc' => 'Public place', 'sequence' => 4],
            ['id' => 6, 'desc' => 'Others' => 5],
        ], ['id']);
    }
}
