<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibNcdClientType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LibNcdClientTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        LibNcdClientType::truncate();
        Schema::enableForeignKeyConstraints();

        LibNcdClientType::upsert([
            ['desc' => 'Walk-in'],
            ['desc' => 'Referred'],
        ], ['id']);
    }
}
