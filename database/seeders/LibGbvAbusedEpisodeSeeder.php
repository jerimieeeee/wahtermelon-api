<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvAbusedEpisode;
use Illuminate\Database\Seeder;

class LibGbvAbusedEpisodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvAbusedEpisode::upsert([
            ['id' => 1, 'desc' => 'Single episode of abuse', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Mutiple episodes over short time period', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Chronic abuse (greater than 6 months)', 'sequence' => 3],
            ['id' => 4, 'desc' => 'Unknown', 'sequence' => 4],
            ['id' => 6, 'desc' => 'Unknown number of episodes', 'sequence' => 5],
        ], ['id']);
    }
}
