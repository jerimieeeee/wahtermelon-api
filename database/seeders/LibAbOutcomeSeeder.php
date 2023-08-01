<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibAbOutcome;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibAbOutcomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibAbOutcome::upsert([
            ['id' => 1, 'desc' => 'Treatment Completed', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Treatment Incomplete', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Death', 'sequence' => 3],
        ], ['id']);
    }
}
