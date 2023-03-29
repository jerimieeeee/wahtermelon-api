<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibNcdLocation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LibNcdLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        LibNcdLocation::truncate();
        Schema::enableForeignKeyConstraints();

        LibNcdLocation::upsert([
            ['desc' => 'Community Level'],
            ['desc' => 'Health Facility'],
        ], ['id']);
    }
}
