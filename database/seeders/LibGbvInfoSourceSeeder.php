<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvInfoSource;
use Illuminate\Database\Seeder;

class LibGbvInfoSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvInfoSource::upsert([
            ['id' => 1, 'desc' => 'Victim survivor', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Historian', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Sworn statement', 'sequence' => 3],
            // ['id' => 4, 'desc' => 'Unknown', 'sequence' => 4],
        ], ['id']);
    }
}
