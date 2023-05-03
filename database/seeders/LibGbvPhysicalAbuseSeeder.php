<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvPhysicalAbuse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibGbvPhysicalAbuseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvPhysicalAbuse::upsert([
            ['id' => 1, 'desc' => 'Hit with hand', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Hit with belt, cord, or stick', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Hit with knife, blade', 'sequence' => 3],
            ['id' => 4, 'desc' => 'Hit with household tool', 'sequence' => 4],
            ['id' => 6, 'desc' => 'Hit with other things', 'sequence' => 5],
            ['id' => 7, 'desc' => 'Burned with cigarette', 'sequence' => 6],
            ['id' => 7, 'desc' => 'Burned with flat iron', 'sequence' => 7],
            ['id' => 8, 'desc' => 'Burned with hot liquid', 'sequence' => 8],
            ['id' => 9, 'desc' => 'Burned with other things', 'sequence' => 9],
            ['id' => 10, 'desc' => 'Biting', 'sequence' => 10],
            ['id' => 11, 'desc' => 'Pinching', 'sequence' => 11],
            ['id' => 12, 'desc' => 'Kicking', 'sequence' => 12],
            ['id' => 13, 'desc' => 'Pulling hair', 'sequence' => 13],
            ['id' => 14, 'desc' => 'Banging head', 'sequence' => 14],
            ['id' => 15, 'desc' => 'Violent shaking', 'sequence' => 15],
            ['id' => 16, 'desc' => 'Dragged', 'sequence' => 16],
            ['id' => 17, 'desc' => 'Other physical abuse', 'sequence' => 17],
        ], ['id']);
    }
}
