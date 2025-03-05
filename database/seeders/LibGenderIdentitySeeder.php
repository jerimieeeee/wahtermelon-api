<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGenderIdentity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibGenderIdentitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGenderIdentity::upsert([
            ['code' => 'L', 'desc' => 'Lesbian', 'sequence' => 1],
            ['code' => 'G', 'desc' => 'Gay', 'sequence' => 2],
            ['code' => 'B', 'desc' => 'Bisexual', 'sequence' => 3],
            ['code' => 'T', 'desc' => 'Transgender', 'sequence' => 4]
        ], ['code']);
    }
}
