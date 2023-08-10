<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibAbAnimalType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibAbAnimalTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibAbAnimalType::upsert([
            ['id' => 1, 'desc' => 'DOG', 'sequence' => 1],
            ['id' => 2, 'desc' => 'CAT', 'sequence' => 2],
            ['id' => 3, 'desc' => 'BAT', 'sequence' => 3],
            ['id' => 4, 'desc' => 'MONKEY', 'sequence' => 4],
            ['id' => 5, 'desc' => 'OTHERS', 'sequence' => 5],
        ], ['id']);
    }
}
