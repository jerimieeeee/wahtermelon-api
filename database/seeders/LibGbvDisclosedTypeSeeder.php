<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvDisclosedType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibGbvDisclosedTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvDisclosedType::upsert([
            ['id' => 1, 'desc' => 'Voluntary', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Elicited', 'sequence' => 2],
        ], ['id']);
    }
}
