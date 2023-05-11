<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvDeferralReason;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibGbvDeferralReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvDeferralReason::upsert([
            ['id' => 1, 'desc' => 'Victim survivor upset', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Not disclosing', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Previous statement was already taken', 'sequence' => 3]
        ], ['id']);
    }
}
