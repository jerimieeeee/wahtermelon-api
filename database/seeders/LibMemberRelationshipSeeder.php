<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibMemberRelationship;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibMemberRelationshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibMemberRelationship::upsert([
            ['id' => 'S', 'desc' => 'Spouse'],
            ['id' => 'C', 'desc' => 'Child'],
            ['id' => 'P', 'desc' => 'Parent'],
        ], ['id']);
    }
}
