<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvNpsStatus;
use Illuminate\Database\Seeder;

class LibGbvNpsStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvNpsStatus::upsert([
            ['id' => 1, 'desc' => 'Dismissed', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Follow up', 'sequence' => 2],
        ], ['id']);
    }
}
