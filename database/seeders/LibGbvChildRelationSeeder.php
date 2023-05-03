<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvChildRelation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibGbvChildRelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvChildRelation::upsert([
            ['id' => 1, 'desc' => 'Father', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Mother', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Siblings', 'sequence' => 3],
        ], ['id']);
    }
}
