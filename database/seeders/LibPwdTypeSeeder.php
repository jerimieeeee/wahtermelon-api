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
            ['type_code' => 'CID', 'sequence' => 1, 'type_desc' => 'Chronic Illness'],
            ['type_code' => 'CD', 'sequence' => 2,  'type_desc' => 'Communication Disability'],
            ['type_code' => 'LD', 'sequence' => 3,  'type_desc' => 'Learning Disability'],
            ['type_code' => 'MD', 'sequence' => 4,  'type_desc' => 'Mental Disability'],
            ['type_code' => 'OD', 'sequence' => 5,  'type_desc' => 'Orthopedic Disability'],
            ['type_code' => 'PD', 'sequence' => 6,  'type_desc' => 'Psychosocial Disability'],
            ['type_code' => 'VD', 'sequence' => 7,  'type_desc' => 'Visual Disability'],
            ['type_code' => 'UN', 'sequence' => 8,  'type_desc' => 'Undefined'],
            ['type_code' => 'NA', 'sequence' => 0,  'type_desc' => 'Not Applicable'],
        ], ['type_desc']);
    }
}
