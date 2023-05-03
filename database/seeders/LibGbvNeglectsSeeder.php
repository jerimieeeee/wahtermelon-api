<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvNeglects;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibGbvNeglectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvNeglects::upsert([
            ['desc' => 'Abandonment', 'sequence' => 1],
            ['desc' => 'Diry, unkempt', 'sequence' => 2],
            ['desc' => 'Undernourished', 'sequence' => 3],
            ['desc' => 'Unrelated medical problems', 'sequence' => 4],
            ['desc' => 'Failing to thrive', 'sequence' => 5],
            ['desc' => 'Delayed development', 'sequence' => 6],
            ['desc' => 'Lack of supervision', 'sequence' => 7],
            ['desc' => 'Neglected schooling', 'sequence' => 8],
            ['desc' => 'Other', 'sequence' => 9],
        ], ['id']);
    }
}
