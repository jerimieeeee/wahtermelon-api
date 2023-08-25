<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibAbRigType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibAbRigTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibAbRigType::upsert([
            ['code' => 'ERIG', 'desc' => 'EQUINE RABIES IMMUNOGLOBULIN', 'sequence' => 1],
            ['code' => 'HRIG', 'desc' => 'HUMAN RABIES IMMUNOGLOBULIN', 'sequence' => 2],
            ['code' => 'NONE', 'desc' => 'NONE', 'sequence' => 3],
        ], ['code']);
    }
}
