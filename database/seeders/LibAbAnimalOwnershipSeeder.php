<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibAbAnimalOwnership;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibAbAnimalOwnershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibAbAnimalOwnership::upsert([
            ['id' => 1, 'desc' => 'Pet', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Stray', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Wild', 'sequence' => 3]
        ], ['id']);
    }
}
