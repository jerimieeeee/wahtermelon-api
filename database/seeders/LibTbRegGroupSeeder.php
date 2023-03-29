<?php

namespace Database\Seeders;

use App\Http\Resources\API\V1\Libraries\LibTbRegGroupResource;
use App\Models\V1\Libraries\LibTbRegGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibTbRegGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibTbRegGroup::upsert([
            ['code' => 'N', 'desc' => 'New', 'sequence' => 1],
            ['code' => 'O', 'desc' => 'Other', 'sequence' => 6],
            ['code' => 'PTLOU', 'desc' => 'Previous Treatment Outcome Unknown', 'sequence' => 3],
            ['code' => 'R', 'desc' => 'Relapse', 'sequence' => 2],
            ['code' => 'TAF', 'desc' => 'Treatment After Failure', 'sequence' => 4],
            ['code' => 'TALF', 'desc' => 'Treatment After Lost to Follow-up', 'sequence' => 5],
        ], ['code']);
    }
}
