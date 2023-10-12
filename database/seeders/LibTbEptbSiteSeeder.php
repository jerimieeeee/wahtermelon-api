<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibTbEptbSite;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LibTbEptbSiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        LibTbEptbSite::truncate();
        Schema::enableForeignKeyConstraints();

        LibTbEptbSite::upsert([
            ['id' => 1, 'desc' => 'Brain/Meninges'],
            ['id' => 2, 'desc' => 'Genito-urinary tract'],
            ['id' => 3, 'desc' => 'Intestine'],
            ['id' => 4, 'desc' => 'Kidney'],
            ['id' => 5, 'desc' => 'Larynx'],
            ['id' => 6, 'desc' => 'Liver'],
            ['id' => 7, 'desc' => 'Lymp nodes'],
            ['id' => 8, 'desc' => 'Skin'],
            ['id' => 9, 'desc' => 'Others'],
            ['id' => 10, 'desc' => 'Bones/Joints'],
        ], ['id']);
    }
}
