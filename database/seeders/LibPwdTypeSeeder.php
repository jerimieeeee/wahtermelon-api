<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibPwdType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibPwdTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibPwdType::upsert([
            ['code' => 'CID', 'sequence' => 1, 'type_desc' => 'Chronic Illness'],
            ['code' => 'CD', 'sequence' => 2,  'type_desc' => 'Communication Disability'],
            ['code' => 'LD', 'sequence' => 3,  'type_desc' => 'Learning Disability'],
            ['code' => 'MD', 'sequence' => 4,  'type_desc' => 'Mental Disability'],
            ['code' => 'OD', 'sequence' => 5,  'type_desc' => 'Orthopedic Disability'],
            ['code' => 'PD', 'sequence' => 6,  'type_desc' => 'Psychosocial Disability'],
            ['code' => 'VD', 'sequence' => 7,  'type_desc' => 'Visual Disability'],
            ['code' => 'UN', 'sequence' => 8,  'type_desc' => 'Undefined'],
            ['code' => 'NA', 'sequence' => 0,  'type_desc' => 'Not Applicable'],
        ], ['type_desc']);
    }
}
