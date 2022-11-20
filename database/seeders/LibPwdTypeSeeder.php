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
            ['code' => 'CN', 'sequence' => 1, 'type_desc' => 'Cancer (RA 11215)'],
            ['code' => 'CID', 'sequence' => 7, 'type_desc' => 'Rare Disease (RA 10747)'], //From Chronic Illness to Rare Disease (RA 10747)
            ['code' => 'CD', 'sequence' => 2,  'type_desc' => 'Deaf or Hard Hearing'], //From Communication Disability to Deaf or hard Hearing
            ['code' => 'LD', 'sequence' => 3,  'type_desc' => 'Intellectual Disability'], //From Learning Disability to Intellectual Disability
            ['code' => 'MD', 'sequence' => 4,  'type_desc' => 'Mental Disability'],
            ['code' => 'OD', 'sequence' => 6,  'type_desc' => 'Physical Disability (Orthopedic)'], //From Orthopedic Disability to Physical Disability (Orthopedic)
            ['code' => 'PD', 'sequence' => 5,  'type_desc' => 'Psychosocial DIsability Speech and Language Impairment'], //From Psychosocial Disability to Psychosocial DIsability Speech and Language Impairment
            ['code' => 'VD', 'sequence' => 8,  'type_desc' => 'Visual Disability'],
            ['code' => 'UN', 'sequence' => 9,  'type_desc' => 'Undefined'],
            ['code' => 'NA', 'sequence' => 0,  'type_desc' => 'Not Applicable'],
        ], ['code']);
    }
}
