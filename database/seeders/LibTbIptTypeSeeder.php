<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibTbIptType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibTbIptTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibTbIptType::upsert([
            ['code' => 'E', 'desc' => 'Exposure'],
            ['code' => 'I', 'desc' => 'Infection']
        ], ['code']);
    }
}
