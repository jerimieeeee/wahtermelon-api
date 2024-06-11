<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibFeedbackQuestion;
use Illuminate\Database\Seeder;

class LibFeedbackQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibFeedbackQuestion::upsert([
            ['id' => 1, 'column_name' => 'overall_score',       'question' => 'Paano mo i-rate ang overall experience mo sa aming health facility?',                                    'question_e' => '', 'sequence' => 1],
            ['id' => 2, 'column_name' => 'cleanliness_score',   'question' => 'Nasisiyahan ka ba sa kalinisan at pamantayan sa kalinisan ng aming facility?',                           'question_e' => '', 'sequence' => 2],
            ['id' => 3, 'column_name' => 'behavior_score',      'question' => 'Paano mo ilalarawan ang behavior at kagandahang-asal ng aming mga staff members?',                       'question_e' => '', 'sequence' => 3],
            ['id' => 4, 'column_name' => 'time_score',          'question' => 'Paano mo ie-rate ang oras ng paghihintay para sa iyong consultation?',                                   'question_e' => '', 'sequence' => 4],
            ['id' => 5, 'column_name' => 'quality_score',       'question' => 'Paano mo i-rate ang kalidad ng alaga at paggamot na iyong natanggap sa iyong visit?',                    'question_e' => '', 'sequence' => 5],
            ['id' => 6, 'column_name' => 'completeness_score',  'question' => 'Lahat ba ng kinakailangang mga procedure at services ay natapos nang maayos para sa iyong kasiyahan?',   'question_e' => '', 'sequence' => 6],
            ['id' => 7, 'column_name' => 'remarks',             'question' => 'Mayroon ka bang karagdagang feedback o comments  na nais mong ibahagi sa amin?',                         'question_e' => '', 'sequence' => 7],
        ], ['id']);
    }
}
