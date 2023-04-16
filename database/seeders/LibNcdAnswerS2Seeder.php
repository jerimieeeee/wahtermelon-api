<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibNcdAnswerS2;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LibNcdAnswerS2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        LibNcdAnswerS2::truncate();
        Schema::enableForeignKeyConstraints();

        LibNcdAnswerS2::upsert([
            ['id' => 'Y', 'desc' => 'Yes'],
            ['id' => 'N', 'desc' => 'No'],
            // ['id' => 'NA', 'desc' => 'Not Applicable'],
        ], ['id']);
    }
}
