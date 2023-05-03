<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvPrimaryComplaints;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibGbvPrimaryComplaintsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvPrimaryComplaints::upsert([
            ['desc' => 'Physical Abuse', 'sequence' => 1],
            ['desc' => 'Sexual Abuse', 'sequence' => 2],
            ['desc' => 'Neglect', 'sequence' => 3],
            ['desc' => 'UTV', 'sequence' => 4],
            ['desc' => 'Others', 'sequence' => 5],
        ], ['id']);
    }
}
