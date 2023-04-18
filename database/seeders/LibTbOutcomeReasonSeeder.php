<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibTbOutcomeReason;
use Illuminate\Database\Seeder;

class LibTbOutcomeReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibTbOutcomeReason::upsert([
            ['id' => 1,     'desc' => 'Personal'],
            ['id' => 2,     'desc' => 'Adversed Event'],
            ['id' => 3,     'desc' => 'Financial: General'],
            ['id' => 4,     'desc' => 'Financial: Transport Costs'],
            ['id' => 5,     'desc' => 'Conflict: Work/School'],
            ['id' => 6,     'desc' => 'Conflict: Family'],
            ['id' => 7,     'desc' => 'Conflict: Health Worker'],
            ['id' => 8,     'desc' => 'Co-mobidity'],
            ['id' => 9,     'desc' => 'Relocation'],
            ['id' => 10,    'desc' => 'TB-related'],
            ['id' => 11,    'desc' => 'Non-TB related'],
        ], ['id']);
    }
}
