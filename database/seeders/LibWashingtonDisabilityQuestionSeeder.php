<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibWashingtonDisabilityQuestion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LibWashingtonDisabilityQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        LibWashingtonDisabilityQuestion::truncate();
        Schema::enableForeignKeyConstraints();

        LibWashingtonDisabilityQuestion::upsert([
            ['desc' => 'Do you have difficulty seeing, even if wearing glasses?',                                                                           'sequence' => 1],
            ['desc' => 'Do you have difficulty hearing, even if using hearing aid?',                                                                        'sequence' => 2],
            ['desc' => 'Do you have difficulty walking or climbing steps?',                                                                                 'sequence' => 3],
            ['desc' => 'Do you have difficulty remembering or concentrating?',                                                                              'sequence' => 4],
            ['desc' => 'Do you have difficulty (with self-care such as) washing all over or dressing?',                                                     'sequence' => 5],
            ['desc' => 'Using your usual language, do you have difficulty communicating, (for example understanding or being understood by others)?',       'sequence' => 6],
        ], ['id']);
    }
}
