<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibWashingtonDisabilityAnswer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LibWashingtonDisabilityAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        LibWashingtonDisabilityAnswer::truncate();
        Schema::enableForeignKeyConstraints();

        LibWashingtonDisabilityAnswer::upsert([
            ['desc' => 'No, no difficulity',             'sequence' => 1],
            ['desc' => 'Yes, some difficulty',           'sequence' => 2],
            ['desc' => 'Yes, a lot of difficulty',       'sequence' => 3],
            ['desc' => 'Cannot do it all',               'sequence' => 4],
        ], ['id']);
    }
}
