<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibAsrhClientType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibAsrhClientTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibAsrhClientType::upsert([
            ['code' => '01', 'desc' => 'MDSW', 'sequence' => 1],
            ['code' => '02', 'desc' => 'Youth Bureau', 'sequence' => 2],
            ['code' => '03', 'desc' => 'School', 'sequence' => 3],
            ['code' => '04', 'desc' => 'Peer Educators', 'sequence' => 4],
            ['code' => '99', 'desc' => 'Others', 'sequence' => 5],
        ], ['code']);
    }
}
