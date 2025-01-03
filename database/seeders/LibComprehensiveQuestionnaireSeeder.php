<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibComprehensiveQuestionnaire;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibComprehensiveQuestionnaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibComprehensiveQuestionnaire::upsert([
            [
                'code' => 'H0101',
                'lib_comprehensive_code' => 'H01',
                'question' => 'Who lives with you? Where do you live?',
                'sequence' => 1
            ],
            [
                'code' => 'H0102',
                'lib_comprehensive_code' => 'H01',
                'question' => 'Ask about people not in the home (for example one of the parents).',
                'sequence' => 2
            ],
            [
                'code' => 'H0103',
                'lib_comprehensive_code' => 'H01',
                'question' => 'Any recent life events (death, illness, separation, others).',
                'sequence' => 3
            ],
            [
                'code' => 'H0104',
                'lib_comprehensive_code' => 'H01',
                'question' => 'Has someone left recently? Is there anyone new at home?',
                'sequence' => 4
            ],
            [
                'code' => 'H0105',
                'lib_comprehensive_code' => 'H01',
                'question' => 'What are relationships like at home?',
                'sequence' => 5
            ],
            [
                'code' => 'H0106',
                'lib_comprehensive_code' => 'H01',
                'question' => 'Can you talk to anyone at home about stress? (Who?)',
                'sequence' => 6
            ],
            [
                'code' => 'H0107',
                'lib_comprehensive_code' => 'H01',
                'question' => 'Have you ever run away? (Why?)',
                'sequence' => 7
            ],
            [
                'code' => 'H0108',
                'lib_comprehensive_code' => 'H01',
                'question' => 'Is there any physical violence at home?',
                'sequence' => 8
            ],
            [
                'code' => 'H0109',
                'lib_comprehensive_code' => 'H01',
                'question' => 'Have you taken part of or been victim of violence at home?',
                'sequence' => 9
            ],



            [
                'code' => 'E0101',
                'lib_comprehensive_code' => 'E01',
                'question' => 'Tell me about school. What school? What year?',
                'sequence' => 1
            ],
            [
                'code' => 'E0102',
                'lib_comprehensive_code' => 'E01',
                'question' => 'Do you feel safe in your school? Do you feel as if you belong?',
                'sequence' => 2
            ],
            [
                'code' => 'E0103',
                'lib_comprehensive_code' => 'E01',
                'question' => 'Is your school a safe place? (Why?) Have you been bullied at school? Is that still a problem?',
                'sequence' => 3
            ],
            [
                'code' => 'E0104',
                'lib_comprehensive_code' => 'E01',
                'question' => 'Tell me about your friends at school.',
                'sequence' => 4
            ],
            [
                'code' => 'E0105',
                'lib_comprehensive_code' => 'E01',
                'question' => 'Are there adults at school you feel you could talk to about something important? (Who?)',
                'sequence' => 5
            ],
            [
                'code' => 'E0106',
                'lib_comprehensive_code' => 'E01',
                'question' => 'What are your favorite subjects at school? Your least favorite subjects?',
                'sequence' => 6
            ],
            [
                'code' => 'E0107',
                'lib_comprehensive_code' => 'E01',
                'question' => 'Do you have any failing grades? Any recent changes? Repeated a grade?',
                'sequence' => 7
            ],
            [
                'code' => 'E0108',
                'lib_comprehensive_code' => 'E01',
                'question' => 'Tell me what you want to do in the future? (vocational goals)',
                'sequence' => 8
            ],


            [
                'code' => 'E0201',
                'lib_comprehensive_code' => 'E02',
                'question' => 'Does your weight or body shape cause you any stress? If so, tell me about it.',
                'sequence' => 1
            ],
            [
                'code' => 'E0202',
                'lib_comprehensive_code' => 'E02',
                'question' => 'Have there been any recent changes in your weight? Have you dieted in the last year? How? How often?',
                'sequence' => 2
            ],
            [
                'code' => 'E0203',
                'lib_comprehensive_code' => 'E02',
                'question' => 'Have you done anything else to try to manage your weight?',
                'sequence' => 3
            ],
            [
                'code' => 'E0204',
                'lib_comprehensive_code' => 'E02',
                'question' => 'Tell me about your exercise routine.',
                'sequence' => 4
            ],


            [
                'code' => 'A0101',
                'lib_comprehensive_code' => 'A01',
                'question' => 'What do you do for fun? How do you spend time with friends? Family? (With whom, where, when?)',
                'sequence' => 1
            ],
            [
                'code' => 'A0102',
                'lib_comprehensive_code' => 'A01',
                'question' => 'Do you participate in any sports? Extracurricular activities? What are your hobbies and interests?',
                'sequence' => 2
            ],
            [
                'code' => 'A0103',
                'lib_comprehensive_code' => 'A01',
                'question' => 'Some teenagers tell me that they spend much of their free time online. What types of things do you use the Internet for?',
                'sequence' => 3
            ],
            [
                'code' => 'A0104',
                'lib_comprehensive_code' => 'A01',
                'question' => 'Which social media sites and/or apps do you typically use?',
                'sequence' => 4
            ],
            [
                'code' => 'A0105',
                'lib_comprehensive_code' => 'A01',
                'question' => 'How many hours do you spend on any given day in front of a screen, such as a computer, TV, or phone? (Concerning response >120 minutes)',
                'sequence' => 5
            ],
            [
                'code' => 'A0106',
                'lib_comprehensive_code' => 'A01',
                'question' => 'Do you wish you spent less time online/on social media? If yes, what have you tried to do to cut down?',
                'sequence' => 6
            ],
            [
                'code' => 'A0107',
                'lib_comprehensive_code' => 'A01',
                'question' => 'Does viewing social media increase or decrease your self-confidence?',
                'sequence' => 7
            ],
            [
                'code' => 'A0108',
                'lib_comprehensive_code' => 'A01',
                'question' => 'Have you personally experienced cyberbullying, sexting or an online user asking to have sexual relations with you?',
                'sequence' => 8
            ],
            [
                'code' => 'A0109',
                'lib_comprehensive_code' => 'A01',
                'question' => 'Have you ever met in person (or plan to meet) with anyone whom you first encountered online?',
                'sequence' => 9
            ],


            [
                'code' => 'D0101',
                'lib_comprehensive_code' => 'D01',
                'question' => 'Do any of your friends or family members use tobacco? Alcohol? Other drugs?',
                'sequence' => 1
            ],
            [
                'code' => 'D0102',
                'lib_comprehensive_code' => 'D01',
                'question' => 'Do you use tobacco, electronic cigarettes, vape? Alcohol? Other drugs, energy drinks, steroids, or medications not prescribed to you?',
                'sequence' => 2
            ],
            [
                'code' => 'D0103',
                'lib_comprehensive_code' => 'D01',
                'question' => 'Do you ever drink or use drugs when you’re alone? (Assess frequency, intensity, patterns of use or abuse, and how patient obtains or pays for drugs, alcohol, or tobacco.)',
                'sequence' => 3
            ],


            [
                'code' => 'S0101',
                'lib_comprehensive_code' => 'S01',
                'question' => 'For young adolescents, inquire if they have questions about pubertal changes (breast, periods, nocturnal emission, erections, masturbation). Ask where they get information about sexuality and provide accurate information or point to online resources.',
                'sequence' => 1
            ],
            [
                'code' => 'S0102',
                'lib_comprehensive_code' => 'S01',
                'question' => 'Gender identity: How do you identify? male, female, questioning? Girls? Both? Not yet sure?',
                'sequence' => 2
            ],
            [
                'code' => 'S0103',
                'lib_comprehensive_code' => 'S01',
                'question' => 'Sexual orientation (attraction) Are you interested in boys? Girls? Both? Not yet sure?',
                'sequence' => 3
            ],
            [
                'code' => 'S0104',
                'lib_comprehensive_code' => 'S01',
                'question' => 'Are you attracted to anyone now? Have you ever been in a romantic relationship?',
                'sequence' => 4
            ],
            [
                'code' => 'S0105',
                'lib_comprehensive_code' => 'S01',
                'question' => 'Have any of your relationships ever been sexual relationships (such as involving kissing, touching, oral, vaginal, anal sex)?',
                'sequence' => 5
            ],
            [
                'code' => 'S0106',
                'lib_comprehensive_code' => 'S01',
                'question' => 'If the adolescent is not sexually active, ask views on abstinence, consent, and safer sex. Provide information and point to online resources.',
                'sequence' => 6
            ],
            [
                'code' => 'S0107',
                'lib_comprehensive_code' => 'S01',
                'question' => 'If sexually active:',
                'sequence' => 7
            ],
            [
                'code' => 'S0108',
                'lib_comprehensive_code' => 'S01',
                'question' => 'Ask about the number, age, and sex of sexual partners.',
                'sequence' => 8
            ],
            [
                'code' => 'S0109',
                'lib_comprehensive_code' => 'S01',
                'question' => 'Were sexual activities consensual?',
                'sequence' => 9
            ],
            [
                'code' => 'S0110',
                'lib_comprehensive_code' => 'S01',
                'question' => 'What are you using for birth control? Do you use condoms every time you have intercourse? What gets in the way?',
                'sequence' => 10
            ],
            [
                'code' => 'S0111',
                'lib_comprehensive_code' => 'S01',
                'question' => '(Girls) Have you ever been pregnant or worried that you may be pregnant?',
                'sequence' => 11
            ],
            [
                'code' => 'S0112',
                'lib_comprehensive_code' => 'S01',
                'question' => '(Boys) Have you ever gotten someone pregnant or worried that might have happened?',
                'sequence' => 12
            ],
            [
                'code' => 'S0113',
                'lib_comprehensive_code' => 'S01',
                'question' => 'Have you ever had a sexually transmitted infection or worried that you had an infection?',
                'sequence' => 13
            ],
            [
                'code' => 'S0114',
                'lib_comprehensive_code' => 'S01',
                'question' => 'Have any of your relationships been violent?',
                'sequence' => 14
            ],
            [
                'code' => 'S0115',
                'lib_comprehensive_code' => 'S01',
                'question' => 'Have you ever been forced or pressured into doing something sexual?',
                'sequence' => 15
            ],
            [
                'code' => 'S0116',
                'lib_comprehensive_code' => 'S01',
                'question' => 'Have you ever been touched sexually in a way that you didn’t want?',
                'sequence' => 16
            ],


            [
                'code' => 'S0201',
                'lib_comprehensive_code' => 'S02',
                'question' => 'Do you feel “stressed” or anxious more than usual? How do you try to cope?',
                'sequence' => 1
            ],
            [
                'code' => 'S0202',
                'lib_comprehensive_code' => 'S02',
                'question' => 'Do you feel sad or down more than usual?',
                'sequence' => 2
            ],
            [
                'code' => 'S0203',
                'lib_comprehensive_code' => 'S02',
                'question' => 'Does it seem that you’ve lost interest in things that you used to really enjoy?',
                'sequence' => 3
            ],
            [
                'code' => 'S0204',
                'lib_comprehensive_code' => 'S02',
                'question' => 'Are you having trouble getting to sleep? How’s your appetite?',
                'sequence' => 4
            ],
            [
                'code' => 'S0205',
                'lib_comprehensive_code' => 'S02',
                'question' => 'Have you thought a lot about hurting yourself or someone else?',
                'sequence' => 5
            ],
            [
                'code' => 'S0206',
                'lib_comprehensive_code' => 'S02',
                'question' => 'Have you ever had to hurt yourself (by cutting yourself, for example) to calm down or feel better?',
                'sequence' => 6
            ],
            [
                'code' => 'S0207',
                'lib_comprehensive_code' => 'S02',
                'question' => 'Have you ever tried to kill yourself?',
                'sequence' => 7
            ],


            [
                'code' => 'S0301',
                'lib_comprehensive_code' => 'S03',
                'question' => 'Have you ever been seriously injured? (How?)',
                'sequence' => 1
            ],
            [
                'code' => 'S0302',
                'lib_comprehensive_code' => 'S03',
                'question' => 'Do you always wear a seatbelt in the car/ a helmet while on a motorcycle?',
                'sequence' => 2
            ],
            [
                'code' => 'S0303',
                'lib_comprehensive_code' => 'S03',
                'question' => 'Do you use safety equipment for sports and/or other physical activities (for example, helmets for biking or skateboarding)?',
                'sequence' => 3
            ],
            [
                'code' => 'S0304',
                'lib_comprehensive_code' => 'S03',
                'question' => 'Is there a lot of violence in your neighborhood?',
                'sequence' => 4
            ],
            [
                'code' => 'S0305',
                'lib_comprehensive_code' => 'S03',
                'question' => 'Have you gotten into physical fights? Have you ever carried a weapon?',
                'sequence' => 5
            ],


            [
                'code' => 'S0401',
                'lib_comprehensive_code' => 'S04',
                'question' => 'What are your sources of hope, strength, comfort or meaning?',
                'sequence' => 1
            ],
            [
                'code' => 'S0402',
                'lib_comprehensive_code' => 'S04',
                'question' => 'For some, their religion acts as a source of comfort; is this true for you?',
                'sequence' => 2
            ],
            [
                'code' => 'S0403',
                'lib_comprehensive_code' => 'S04',
                'question' => 'Are you part of a religious or spiritual community? What practices do you find most helpful to you personally?',
                'sequence' => 3
            ],

        ], ['code']);
    }
}
