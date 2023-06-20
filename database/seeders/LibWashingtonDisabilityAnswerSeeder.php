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
            ['id' => 1, 'desc' => 'No, no difficulty',              'sequence' => 1],
            ['id' => 2, 'desc' => 'Yes, some difficulty',           'sequence' => 2],
            ['id' => 3, 'desc' => 'Yes, a lot of difficulty',       'sequence' => 3],
            ['id' => 4, 'desc' => 'Cannot do it at all',            'sequence' => 4],
        ], ['id']);
    }
}
