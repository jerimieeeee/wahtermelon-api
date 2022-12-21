<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibNcdSmokingAnswer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LibNcdSmokingAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        LibNcdSmokingAnswer::truncate();
        Schema::enableForeignKeyConstraints();

        LibNcdSmokingAnswer::upsert([
          ['desc' => 'Never Smoked'],
          ['desc' => 'Stopped more than a year'],
          ['desc' => 'Current Smoker'],
          ['desc' => 'Stopped less than a year'],
          ['desc' => 'Passive Smoker'],
        ], ['id']);
    }
}
