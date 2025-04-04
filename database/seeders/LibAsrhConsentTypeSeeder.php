<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibAsrhClientType;
use App\Models\V1\Libraries\LibAsrhConsentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibAsrhConsentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibAsrhConsentType::upsert([
            ['id' => 1, 'desc' => 'Parent'],
            ['id' => 2, 'desc' => 'Guardian'],
            ['id' => 3, 'desc' => 'Spouse'],
            ['id' => 4, 'desc' => 'Sibling'],
            ['id' => 5, 'desc' => 'Relative'],
            ['id' => 6, 'desc' => 'Friend'],
            ['id' => 99, 'desc' => 'Others, specify'],
        ], ['id']);
    }
}
