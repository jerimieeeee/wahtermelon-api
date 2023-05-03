<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvChildBehavior;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibGbvChildBehaviorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvChildBehavior::upsert([
            ['id' => 1, 'desc' => 'Cooperative', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Crying, very upset', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Clinging to caretaker', 'sequence' => 3],
            ['id' => 4, 'desc' => 'Responsive to most questions', 'sequence' => 4],
            ['id' => 5, 'desc' => 'Silent, unresponsive', 'sequence' => 5],
            ['id' => 6, 'desc' => 'Able to narrate incident', 'sequence' => 6],
            ['id' => 7, 'desc' => 'Unable to narrate incident', 'sequence' => 7],
            ['id' => 8, 'desc' => 'Appropriate affect', 'sequence' => 8],
            ['id' => 9, 'desc' => 'Depressed affect', 'sequence' => 9],
            ['id' => 10, 'desc' => 'Flat affect, blank stares', 'sequence' => 10],
            ['id' => 11, 'desc' => 'Psychotic symptoms', 'sequence' => 11],
            ['id' => 12, 'desc' => 'Combative, hostile', 'sequence' => 12],
            ['id' => 13, 'desc' => 'Hyperactive, anxious', 'sequence' => 13],
            ['id' => 14, 'desc' => 'Short attention span', 'sequence' => 14],
        ], ['id']);
    }
}
