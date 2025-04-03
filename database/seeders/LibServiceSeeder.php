<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibService::upsert([
            ['id' => 'IRON', 'desc' => 'IRON SUPPLEMENT'],
        ], ['id']);
    }
}
