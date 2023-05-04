<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvPsychParticipant;
use Illuminate\Database\Seeder;

class LibGbvPsychParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvPsychParticipant::upsert([
            ['id' => 1, 'desc' => 'Child is alone', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Child and parent', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Whole family', 'sequence' => 3],
            ['id' => 4, 'desc' => 'Perpetrator', 'sequence' => 4],
        ], ['id']);
    }
}
