<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibTbEptbSite;
use Illuminate\Database\Seeder;

class LibTbEptbSiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibTbEptbSite::upsert([
            ['id' => 0, 'desc' => 'Bones/Joints'],
            ['id' => 1, 'desc' => 'Brain/Meninges'],
            ['id' => 2, 'desc' => 'Genito-urinary tract'],
            ['id' => 3, 'desc' => 'Intestine'],
            ['id' => 4, 'desc' => 'Kidney'],
            ['id' => 5, 'desc' => 'Larynx'],
            ['id' => 6, 'desc' => 'Liver'],
            ['id' => 7, 'desc' => 'Lymp nodes'],
            ['id' => 8, 'desc' => 'Skin'],
            ['id' => 9, 'desc' => 'Others'],
        ], ['id']);
    }
}
