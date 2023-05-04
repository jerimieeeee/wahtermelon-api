<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvConferenceConcern;
use Illuminate\Database\Seeder;

class LibGbvConferenceConcernSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvConferenceConcern::upsert([
            ['id' => 1, 'desc' => 'Child in unsafe home', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Perpetrator likely has access', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Perpetrator remains unknown', 'sequence' => 3],
            ['id' => 4, 'desc' => 'Findings of abuse, no disclosure', 'sequence' => 4],
            ['id' => 5, 'desc' => 'Concurrent spouse abuse', 'sequence' => 5],
            ['id' => 6, 'desc' => 'Drug abuse with home', 'sequence' => 6],
            ['id' => 7, 'desc' => 'Unrelated medical problems', 'sequence' => 7],
            ['id' => 8, 'desc' => 'Missed follow-up appointment(s)', 'sequence' => 8],
            ['id' => 9, 'desc' => 'Others', 'sequence' => 9],
        ], ['id']);
    }
}
