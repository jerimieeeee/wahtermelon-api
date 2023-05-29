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
            ['id' => 1, 'desc' => 'MD', 'sequence' => 1],
            ['id' => 2, 'desc' => 'SW', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Psychiatrist', 'sequence' => 3],
            ['id' => 4, 'desc' => 'WCPU', 'sequence' => 4],
            ['id' => 5, 'desc' => 'Others', 'sequence' => 5],
        ], ['id']);
    }
}
