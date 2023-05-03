<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvEmotionalAbuse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibGbvEmotionalAbuseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvEmotionalAbuse::upsert([
            ['id' => 1, 'desc' => 'Insulting, cursing, belittling', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Threatening/Terrorizing', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Other', 'sequence' => 3],
        ], ['id']);
    }
}
