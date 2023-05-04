<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvConferenceInvitee;
use Illuminate\Database\Seeder;

class LibGbvConferenceInviteeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvConferenceInvitee::upsert([
            ['id' => 1, 'desc' => 'CPU MD', 'sequence' => 1],
            ['id' => 2, 'desc' => 'CPU SW', 'sequence' => 2],
            ['id' => 3, 'desc' => 'CPU Psychiatrist', 'sequence' => 3],
            ['id' => 4, 'desc' => 'CPU Nurse', 'sequence' => 4],
            ['id' => 5, 'desc' => 'Others', 'sequence' => 5],
        ], ['id']);
    }
}
