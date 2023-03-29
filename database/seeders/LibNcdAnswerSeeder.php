<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibNcdAnswer;
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
            ['id' => 'Y', 'desc' => 'Yes'],
            ['id' => 'N', 'desc' => 'No'],
            ['id' => 'X', 'desc' => 'Unknown'],
            //   ['id' => 'NA', 'desc' => 'Not Applicable'],
        ], ['id']);
    }
}
