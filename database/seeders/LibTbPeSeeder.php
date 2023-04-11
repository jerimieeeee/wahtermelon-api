<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibTbPe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibTbPeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibTbPe::upsert([
            ['code' => 'abdomen',      'desc' => 'Abdomen',                    'sequence' => 8],
            ['code' => 'bcg',           'desc' => 'BCG Scar',                   'sequence' => 3],
            ['code' => 'cardiovascular','desc' => 'Cardiovascular',             'sequence' => 5],
            ['code' => 'extremities',   'desc' => 'Extremities',                'sequence' => 10],
            ['code' => 'endocrine',     'desc' => 'Endocrine',                  'sequence' => 13],
            ['code' => 'ghealth',       'desc' => 'General Health',             'sequence' => 1],
            ['code' => 'gurinary',      'desc' => 'Genito-urinary',             'sequence' => 9],
            ['code' => 'lnodes',        'desc' => 'Lymph Nodes',                'sequence' => 12],
            ['code' => 'neurological',  'desc' => 'Neurological',               'sequence' => 11],
            ['code' => 'oropharynx',    'desc' => 'Oropharynx',                 'sequence' => 4],
            ['code' => 'skin',          'desc' => 'Skin',                       'sequence' => 2],
            ['code' => 'thoraxlungs',   'desc' => 'Thorax & Lungs',             'sequence' => 6],
            ['code' => 'amuscles',      'desc' => 'Use of Accessory Muscles',   'sequence' => 7]
        ], ['code']);
    }
}
