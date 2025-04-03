<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LibAsrhAlgorithmPivotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lib_asrh_algorithm_pivot')->truncate();
        DB::table('lib_asrh_algorithm_pivot')->upsert([
            ['id' => Str::ulid(), 'lib_rapid_questionnaire_id' => 1, 'lib_asrh_algorithm_code' => 'G2'],
            ['id' => Str::ulid(), 'lib_rapid_questionnaire_id' => 1, 'lib_asrh_algorithm_code' => 'G3'],
            ['id' => Str::ulid(), 'lib_rapid_questionnaire_id' => 1, 'lib_asrh_algorithm_code' => 'G4'],
            ['id' => Str::ulid(), 'lib_rapid_questionnaire_id' => 1, 'lib_asrh_algorithm_code' => 'G5'],
            ['id' => Str::ulid(), 'lib_rapid_questionnaire_id' => 1, 'lib_asrh_algorithm_code' => 'G6'],

            ['id' => Str::ulid(), 'lib_rapid_questionnaire_id' => 4, 'lib_asrh_algorithm_code' => 'F1'],
            ['id' => Str::ulid(), 'lib_rapid_questionnaire_id' => 4, 'lib_asrh_algorithm_code' => 'F2'],
            ['id' => Str::ulid(), 'lib_rapid_questionnaire_id' => 4, 'lib_asrh_algorithm_code' => 'F3'],

            ['id' => Str::ulid(), 'lib_rapid_questionnaire_id' => 10, 'lib_asrh_algorithm_code' => 'G4'],
            ['id' => Str::ulid(), 'lib_rapid_questionnaire_id' => 10, 'lib_asrh_algorithm_code' => 'H9'],

            ['id' => Str::ulid(), 'lib_rapid_questionnaire_id' => 3, 'lib_asrh_algorithm_code' => 'E2'],
            ['id' => Str::ulid(), 'lib_rapid_questionnaire_id' => 3, 'lib_asrh_algorithm_code' => 'G5'],

            ['id' => Str::ulid(), 'lib_rapid_questionnaire_id' => 5, 'lib_asrh_algorithm_code' => 'D3'],

            ['id' => Str::ulid(), 'lib_rapid_questionnaire_id' => 6, 'lib_asrh_algorithm_code' => 'D1'],

            ['id' => Str::ulid(), 'lib_rapid_questionnaire_id' => 7, 'lib_asrh_algorithm_code' => 'D2'],

            ['id' => Str::ulid(), 'lib_rapid_questionnaire_id' => 8, 'lib_asrh_algorithm_code' => 'G4'],

            ['id' => Str::ulid(), 'lib_rapid_questionnaire_id' => 9, 'lib_asrh_algorithm_code' => 'G4'],
            ['id' => Str::ulid(), 'lib_rapid_questionnaire_id' => 9, 'lib_asrh_algorithm_code' => 'H6'],
            ['id' => Str::ulid(), 'lib_rapid_questionnaire_id' => 9, 'lib_asrh_algorithm_code' => 'H7'],
            ['id' => Str::ulid(), 'lib_rapid_questionnaire_id' => 9, 'lib_asrh_algorithm_code' => 'H8'],
            ['id' => Str::ulid(), 'lib_rapid_questionnaire_id' => 10, 'lib_asrh_algorithm_code' => 'H9'],
        ],['lib_rapid_questionnaire_id', 'lib_asrh_algorithm_code'], ['id']);
    }
}
