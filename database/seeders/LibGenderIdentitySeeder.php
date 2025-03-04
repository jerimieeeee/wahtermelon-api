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
            ['code' => 'M', 'desc' => 'Male', 'sequence' => 1],
            ['code' => 'F', 'desc' => 'Female', 'sequence' => 2],
            ['code' => 'L', 'desc' => 'Lesbian', 'sequence' => 3],
            ['code' => 'G', 'desc' => 'Gay', 'sequence' => 4],
            ['code' => 'B', 'desc' => 'Bisexual', 'sequence' => 5],
            ['code' => 'T', 'desc' => 'Transgender', 'sequence' => 6]
        ], ['code']);
    }
}
