<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibComprehensive;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibComprehensiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibComprehensive::upsert([
            [
                'code' => 'H01',
                'desc' => 'HOME',
                'instruction' => 'The interview can start with a discussion of the adolescent’s home and the environment where they live.',
                'sequence' => 1
            ],
            [
                'code' => 'E01',
                'desc' => 'EDUCATION & EMPLOYMENT',
                'instruction' => 'Prompt the young person to tell you about school/work. Poor school performance can signal developmental, mental or psychosocial problems.',
                'sequence' => 2
            ],
            [
                'code' => 'E02',
                'desc' => 'EATING',
                'instruction' => 'Unhealthy eating habits are common and can lead to a serious eating disorder or overweight and obesity.<br>Talking about eating habits and exercise could help set up a healthier lifestyle.',
                'sequence' => 3
            ],
            [
                'code' => 'A01',
                'desc' => 'ACTIVITIES',
                'instruction' => 'Asking adolescents about the activities may reveal their strengths and their difficulties.<br>Time spent online may have an impact on sleep, physical activities, and studies. Elicit online bullying, child sexual abuse and sexting since these are emerging concerns.',
                'sequence' => 4
            ],
            [
                'code' => 'D01',
                'desc' => 'DRUGS',
                'instruction' => 'Using a “third person” approach is appropriate when asking sensitive questions.',
                'sequence' => 5
            ],
            [
                'code' => 'S01',
                'desc' => 'SEXUALITY',
                'instruction' => 'This part is very sensitive, and it is important that questions are asked respectfully. One may choose to ask permission by saying, “Do you mind if I ask you more personal questions?”, or “The next questions are sensitive, but I ask these questions to all my patients”.',
                'sequence' => 6
            ],
            [
                'code' => 'S02',
                'desc' => 'SUICIDE & DEPRESSION',
                'instruction' => 'Young people are more likely to admit stress and anxiety than depression. About 50% of mental health disorders develop during adolescence.<br/>It’s important to remember that asking about suicide does NOT trigger suicidal thoughts or attempts.',
                'sequence' => 7
            ],
            [
                'code' => 'S03',
                'desc' => 'SAFETY',
                'instruction' => 'The top causes of death among young people are from injuries, homicide, and suicide. These are mostly preventable causes of death.',
                'sequence' => 8
            ],
            [
                'code' => 'S04',
                'desc' => 'SPIRITUALITY',
                'instruction' => 'Questions on spirituality may be asked to determine whether spiritual factors may play a role in the patient’s illness or recovery.',
                'sequence' => 9
            ],

        ], ['code']);
    }
}
