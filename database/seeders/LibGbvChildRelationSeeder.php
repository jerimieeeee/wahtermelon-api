<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvChildRelation;
use Illuminate\Database\Seeder;

class LibGbvChildRelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvChildRelation::upsert([
            ['id' => 1, 'desc' => 'Grandparent', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Parent', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Sibling', 'sequence' => 3],
            ['id' => 4, 'desc' => 'Significant others', 'sequence' => 4],
            ['id' => 5, 'desc' => 'Physician', 'sequence' => 5],
            ['id' => 6, 'desc' => 'Social Worker', 'sequence' => 6],
            ['id' => 7, 'desc' => 'WCPD', 'sequence' => 7],
            ['id' => 8, 'desc' => 'Others', 'sequence' => 8],
        ], ['id']);
    }
}
