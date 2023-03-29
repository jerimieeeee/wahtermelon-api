<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibNcdAlcoholIntakeAnswer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LibNcdAlocoholIntakeAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        LibNcdAlcoholIntakeAnswer::truncate();
        Schema::enableForeignKeyConstraints();

        LibNcdAlcoholIntakeAnswer::upsert([
            ['desc' => 'Yes, Drinks Alcohol'],
            ['desc' => 'Never Consumed'],
        ], ['id']);
    }
}
