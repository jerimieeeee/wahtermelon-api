<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvInfoSource;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibGbvInfoSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvInfoSource::upsert([
            ['desc' => 'Child/Adolescent/Woman', 'sequence' => 1],
            ['desc' => 'Historian', 'sequence' => 2],
            ['desc' => 'Sworn statement', 'sequence' => 3],
        ], ['id']);
    }
}
