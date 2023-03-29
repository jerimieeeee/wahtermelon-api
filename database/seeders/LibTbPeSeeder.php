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
            ['code' => 'A',     'desc' => 'Abdomen',                    'sequence' => 8],
            ['code' => 'BCG',   'desc' => 'BCG Scar',                   'sequence' => 3],
            ['code' => 'C',     'desc' => 'Cardiovascular',             'sequence' => 5],
            ['code' => 'E',     'desc' => 'Extremities',                'sequence' => 10],
            ['code' => 'EC',    'desc' => 'Endocrine',                  'sequence' => 13],
            ['code' => 'GH',    'desc' => 'General Health',             'sequence' => 1],
            ['code' => 'GU',    'desc' => 'Genito-urinary',             'sequence' => 9],
            ['code' => 'LN',    'desc' => 'Lymph Nodes',                'sequence' => 12],
            ['code' => 'N',     'desc' => 'Neurological',               'sequence' => 11],
            ['code' => 'O',     'desc' => 'Oropharynx',                 'sequence' => 4],
            ['code' => 'S',     'desc' => 'Skin',                       'sequence' => 2],
            ['code' => 'TL',    'desc' => 'Thorax & Lungs',             'sequence' => 6],
            ['code' => 'UAM',   'desc' => 'Use of Accessory Muscles',   'sequence' => 7]
        ], ['code']);
    }
}
