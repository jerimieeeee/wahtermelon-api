<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibNcdAnswer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LibNcdAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        LibNcdAnswer::truncate();
        Schema::enableForeignKeyConstraints();

        LibNcdAnswer::upsert([
          ['desc' => 'Yes'],
          ['desc' => 'No'],
          ['desc' => 'Unknown'],
          ['desc' => 'Not Applicable'],
        ], ['id']);
    }
}
