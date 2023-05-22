<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvNeglects;
use Illuminate\Database\Seeder;

class LibGbvNeglectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvNeglects::upsert([
            ['id' => 1, 'desc' => 'Abandonment', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Dirty, unkempt', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Undernourished', 'sequence' => 3],
            ['id' => 4, 'desc' => 'Unrelated medical problems', 'sequence' => 4],
            ['id' => 5, 'desc' => 'Failing to thrive', 'sequence' => 5],
            ['id' => 6, 'desc' => 'Delayed development', 'sequence' => 6],
            ['id' => 7, 'desc' => 'Lack of supervision', 'sequence' => 7],
            ['id' => 8, 'desc' => 'Neglected schooling', 'sequence' => 8],
            ['id' => 9, 'desc' => 'Other', 'sequence' => 9],
        ], ['id']);
    }
}
