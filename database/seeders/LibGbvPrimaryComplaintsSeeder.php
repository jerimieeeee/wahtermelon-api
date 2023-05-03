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
            ['id' => 1, 'desc' => 'Physical Abuse', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Sexual Abuse', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Neglect', 'sequence' => 3],
            ['id' => 4, 'desc' => 'UTV', 'sequence' => 4],
            ['id' => 5, 'desc' => 'Others', 'sequence' => 5],
        ], ['id']);
    }
}
