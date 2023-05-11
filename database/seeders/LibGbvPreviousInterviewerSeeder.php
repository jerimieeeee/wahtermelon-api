<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvPreviousInterviewer;
use Illuminate\Database\Seeder;

class LibGbvPreviousInterviewerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvPreviousInterviewer::upsert([
            ['id' => 1, 'desc' => 'NBI', 'sequence' => 1],
            ['id' => 2, 'desc' => 'PNP', 'sequence' => 2],
            ['id' => 3, 'desc' => 'DSWD', 'sequence' => 3],
            ['id' => 4, 'desc' => 'Other', 'sequence' => 4],
            // ['id' => 4, 'desc' => 'Unknown', 'sequence' => 4],
        ], ['id']);
    }
}
