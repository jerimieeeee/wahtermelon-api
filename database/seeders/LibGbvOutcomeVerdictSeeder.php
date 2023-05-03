<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvOutcomeVerdict;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibGbvOutcomeVerdictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvOutcomeVerdict::upsert([
            ['id' => 1, 'desc' => 'Guilty - Imprisonment', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Guilty - Death', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Acquitted', 'sequence' => 3],
            ['id' => 4, 'desc' => 'Dismissed', 'sequence' => 4],
            ['id' => 5, 'desc' => 'Case withdrawn', 'sequence' => 5]
        ], ['id']);
    }
}
