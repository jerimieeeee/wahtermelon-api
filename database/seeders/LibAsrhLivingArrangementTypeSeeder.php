<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibAsrhLivingArrangementType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibAsrhLivingArrangementTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibAsrhLivingArrangementType::upsert([
            ['id' => 1, 'desc' => 'Living in with partner'],
            ['id' => 2, 'desc' => 'Living with family'],
            ['id' => 3, 'desc' => 'Living with extended family'],
            ['id' => 4, 'desc' => 'Living alone'],
            ['id' => 5, 'desc' => 'Living in shelter'],
        ], ['id']);
    }
}
