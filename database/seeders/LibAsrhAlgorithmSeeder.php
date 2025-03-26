<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibAsrhAlgorithm;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibAsrhAlgorithmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibAsrhAlgorithm::upsert([
            [
                'code' => 'D1',
                'desc' => 'Alcohol Use',
                'ask_instruction' => json_encode([
                    'questions' => [
                        ['question' => 'Do you have friends or family members who drink alcohol?'],
                        ['question' => 'Have you been invited to drink alcohol? Have you tried drinking?'],
                        ['question' => 'If yes, when did you start drinking?'],
                        ['question' => 'How did you start drinking? Were you invited?'],
                        ['question' => 'What do you usually drink?'],
                        ['question' => 'How much or how many bottles do you drink?'],
                        ['question' => 'How often do you drink? Do you drink more often now than before?'],
                        [
                            'question' => 'What effects does drinking have on you?',
                            'options' => [
                                'Do you black out or forget what happened?',
                                'Cannot recall?'
                            ]
                        ],
                        ['question' => 'Do you want to quit drinking or do you intend to continue drinking?'],
                        [
                            'question' => 'Have any of the following happened to you for at least 12 months?',
                            'options' => [
                                'Alcohol often taken in larger amounts or over a longer period than intended?',
                                'Persistent desire but unsuccessful efforts to cut down alcohol use?',
                                'Recurrent alcohol use resulting in failure at work, school, home, and interpersonal relations?',
                                'Recurrent alcohol use in physically hazardous situations?'
                            ]
                        ],
                        ['question' => 'If you haven’t drunk alcohol, do you intend to drink alcohol?']
                    ]
                ]),
                'sequence' => 1,
            ],
            [
                'code' => 'D2',
                'desc' => 'Substance Use',
                'ask_instruction' => json_encode([
                    'questions' => [
                        ['question' => 'Do you have friends or family members who have tried drugs?'],
                        ['question' => 'Have you been invited to try drugs? Have you tried drugs?'],
                        ['question' => 'If YES, when did you start using drugs?'],
                        ['question' => 'What drugs did you try?'],
                        ['question' => 'How many times have you tried using it?'],
                        ['question' => 'How often do you use it? Are you using it more often now than before?'],
                        ['question' => 'What effects does it have on you?'],
                        ['question' => 'Do you plan to quit?'],
                        ['question' => 'If you are no longer using drugs, do you still intend to use?'],
                        ['question' => 'Did you take or use one or more substances over a 12-month period?'],
                        ['question' => 'Do you have a strong desire to use?'],
                        ['question' => 'Did you have a marked change in emotional state or behavior due to repeated use?'],
                        ['question' => 'Did you fail to fulfill obligations at home, school, or work due to substance use?'],
                        ['question' => 'Did you continue substance use despite its effects?'],
                        ['question' => 'Do you have a persistent desire or unsuccessful efforts to cut down or control substance use?'],
                        ['question' => 'If you HAVE NOT tried drugs, do you intend to try any drugs?']
                    ]
                ]),
                'sequence' => 2,
            ],
            [
                'code' => 'D3',
                'desc' => 'Smoking, Vaping, and Tobacco Use',
                'ask_instruction' => json_encode([
                    'questions' => [
                        ['question' => 'Do you have friends/family members who smoke/vape?'],
                        ['question' => 'Has anyone encouraged/invited you to smoke/vape?'],
                        ['question' => 'Have you tried smoking or vaping?'],
                        ['question' => 'If YES: When did you start?'],
                        ['question' => 'How often do you smoke/vape?'],
                        ['question' => 'How much do you smoke/vape in a day? Do you smoke/vape more now than before?'],
                        ['question' => 'How do you pay for it?'],
                        ['question' => 'What effects does it have on you?'],
                        ['question' => 'Do you plan to quit?'],
                        ['question' => 'If you are NOT smoking/vaping now, do you still want to try it?'],
                    ]
                ]),
                'sequence' => 3,
            ],
            [
                'code' => 'E2',
                'desc' => 'Bullying',
                'ask_instruction' => json_encode([
                    'questions' => [
                        ['question' => 'Have you heard about or seen bullying happening in school?'],
                        ['question' => 'How did the school handle it?'],
                        ['question' => 'What do you think of it? What would you have done if you were there?'],
                        ['question' => 'You seem stressed/upset. Has anything happened? Is there something going on at school that might be upsetting you? Has anything happened between you and your friends in school?'],
                        ['question' => 'Do you sometimes feel sick or have frequent pains like headache or stomachache?'],
                        [
                            'question' => 'Find out if there is a history of the following:',
                            'options' => [
                                'Unexplainable injuries',
                                'Lost or destroyed clothing, books, electronics, or jewelry',
                                'Faking illness',
                                'Change in eating habits',
                                'Difficulty sleeping or frequent nightmares',
                                'Declining grades, loss of interest in school, or not wanting to go to school',
                                'Sudden loss of friends or avoidance of social situations',
                                'Feelings of helplessness or lowered self-esteem',
                                'Running away, harming themselves, or talking about suicide'
                            ]
                        ]
                    ]
                ]),
                'sequence' => 4,
            ],
            [
                'code' => 'F1',
                'desc' => 'Depression',
                'ask_instruction' => json_encode([
                    'questions' => [
                        ['question' => 'Do you often complain of headache, stomachache or sickness? Or persistently experience multiple physical symptoms with no clear cause?'],
                        [
                            'question' => 'Have you experienced any of the following in the last 2 weeks or for at least 2 weeks?',
                            'options' => [
                                'Persistent depressed mood',
                                'Much diminished interest in or pleasure in activities',
                                'Disturbed sleep or sleeping too much',
                                'Significant change in appetite or weight',
                                'Thoughts of worthlessness or excessive guilt',
                                'Fatigue or loss of energy',
                                'Reduced concentration',
                                'Indecisiveness',
                                'Observable agitation or physical restlessness',
                                'Talking or moving more slowly than usual',
                                'Hopelessness',
                                'Suicidal acts or thoughts'
                            ]
                        ],
                        ['question' => 'Are you having difficulty with your daily personal, family, social, educational or other functions?'],
                        ['question' => 'Are there events that trigger stress in you?'],
                        ['question' => 'Have you had similar problems in the past?'],
                        ['question' => 'How do you usually cope with difficulties?'],
                        ['question' => 'Which of these ways worked and which did not?'],
                        ['question' => 'Who can you run to for support? How is your relationship with them?'],
                        ['question' => 'Have you ever sought professional help for mental health concerns?'],
                        ['question' => 'Do you have an emergency contact list?'],
                        ['question' => 'Are you currently taking any medications or undergoing therapy for mental health? Do you regularly take these medications and regularly undergo therapy?'],
                    ]
                ]),
                'sequence' => 5,
            ],
            [
                'code' => 'F2',
                'desc' => 'Anxiety Disorder',
                'ask_instruction' => json_encode([
                    'questions' => [
                        ['question' => 'Have you been bothered by the following problems over the last 2 weeks?'],
                        [
                            'question' => 'Feeling nervous, anxious or on edge',
                        ],
                        [
                            'question' => 'Not being able to sleep or control worrying',
                        ],
                        ['question' => 'Do you have difficulties in doing schoolwork, helping at home, or getting along with other people?'],
                        ['question' => 'Do you have frequent panic attacks? How often? For how long? And how severe? How and when does it start?'],
                        ['question' => 'Did you have specific thoughts that trigger anxiety?'],
                        ['question' => 'Were there associated symptoms during the episodes?'],
                        ['question' => 'Did your anxiety interfere with everyday life?'],
                        [
                            'question' => 'Were there co-existing problems?',
                            'options' => [
                                'Sleeping problems',
                                'Eating problems',
                                'Behavioral problems',
                                'Drug and substance abuse'
                            ]
                        ],
                        ['question' => 'Was there family history of anxiety or panic attacks?'],
                        ['question' => 'Do you drink coffee or other caffeinated beverages?'],
                        ['question' => 'Do you smoke cigarettes or vape?'],
                    ]
                ]),
                'sequence' => 6,
            ],
            [
                'code' => 'F3',
                'desc' => 'Suicide',
                'ask_instruction' => json_encode([
                    'questions' => [
                        ['question' => 'Do you feel extreme hopelessness and despair?'],
                        ['question' => 'Have you wished you were dead or will not wake up from sleep?'],
                        ['question' => 'Have you had thoughts of killing yourself?'],
                        ['question' => 'Have you been thinking about how you might kill yourself?'],
                        ['question' => 'Have you had these thoughts and had some intention of acting on them?'],
                        ['question' => 'Have you started to work out or planned the details of how to kill yourself? Do you intend to carry out this plan?'],
                        ['question' => 'Do you know anyone who recently attempted to commit suicide or died from suicide?'],
                        ['question' => 'Do you have friends who are also having suicidal thoughts?'],
                        ['question' => 'Have you ever thought of harming yourself?'],
                        ['question' => 'Have you ever done or started to do anything to hurt yourself?'],
                        ['question' => 'When was the last time you did something to hurt yourself?'],
                    ]
                ]),
                'sequence' => 7,
            ],
            [
                'code' => 'G2',
                'desc' => 'Violence',
                'ask_instruction' => json_encode([
                    'questions' => [
                        ['question' => 'Have you been involved in fights?'],
                        ['question' => 'Involved in gangs?'],
                        ['question' => 'When was your last fight?'],
                        ['question' => 'Have you ever been injured in a fight?'],
                        ['question' => 'Have you ever injured someone else in a fight?'],
                        ['question' => 'Has your partner ever hit or hurt you?'],
                        ['question' => 'Have you ever hit or hurt your partner?'],
                        ['question' => 'Have you been forced to have sex against your will?'],
                        ['question' => 'Has someone carrying a weapon ever threatened you? What happened?'],
                        ['question' => 'Has anything changed since then to make you feel safer?'],
                        ['question' => 'What do you do if someone tries to pick a fight with you?'],
                        ['question' => 'Have you ever carried a weapon in self-defense?'],
                        ['question' => 'Do you ever have thoughts of hurting yourself?'],
                        ['question' => 'Do you have a plan?'],
                        ['question' => 'Do you have access to what you need to carry out your plan?'],
                        ['question' => 'Have you been exposed to violent discipline or have a history of aggressive behavior?'],
                        ['question' => 'How much exposure do you have to social media violence?'],
                        ['question' => 'Do you have any history of multiple or serious injuries?'],
                        ['question' => 'Are you involved or engaged in alcohol/drugs/substance use?'],
                    ]
                ]),
                'sequence' => 8,
            ],
            [
                'code' => 'G3',
                'desc' => 'Physical Abuse',
                'ask_instruction' => json_encode([
                    'questions' => [
                        ['question' => 'How did you get this injury/bruise?'],
                        ['question' => 'Have you ever been hurt physically by a friend or person you know? Where did this happen?'],
                        ['question' => 'In any of these incidents, were there weapons involved?'],
                        ['question' => 'Have you ever been threatened by someone?'],
                        ['question' => 'Have you seen anyone, especially a loved one, being hurt, at home or in any place?'],
                        ['question' => 'Have you been threatened, scolded or harmed because of your gender preference?'],
                    ]
                ]),
                'sequence' => 9,
            ],
            [
                'code' => 'G4',
                'desc' => 'Sexual Abuse',
                'ask_instruction' => json_encode([
                    'questions' => [
                        ['question' => 'Do you ever feel afraid of or feel controlled by a friend or someone you are dating?'],
                        ['question' => 'Have you ever been hurt or threatened by someone?'],
                        ['question' => 'Have you been forced to have sex without your consent?'],
                    ]
                ]),
                'sequence' => 10,
            ],
            [
                'code' => 'G5',
                'desc' => 'Cyberbullying',
                'ask_instruction' => json_encode([
                    'questions' => [
                        ['question' => 'Has anything made you feel stressed, anxious, or upset?'],
                        ['question' => 'Have you been spending more time alone on your phone or in your room? Do you want to talk about it?'],
                        ['question' => 'Is there something going on in school that might be upsetting you?'],
                        ['question' => 'Have you stopped talking about your friends? Has anything happened?'],
                        [
                            'question' => 'Find out if there is a history of the following:',
                            'options' => [
                                'Unexplained stomachaches or headaches',
                                'Unexplained weight loss or gain',
                                'Trouble sleeping',
                                'Noticeable increase or decrease in device use',
                                'Showing emotional responses to what is seen/read on their device',
                                'Hiding gadget screen when someone is near, and avoiding discussing what they were doing on their device',
                                'Social media accounts shut down or new ones created',
                                'Avoiding social situations, even those they used to enjoy',
                                'Becoming withdrawn or depressed, or losing interest in people and activities'
                            ]
                        ]
                    ]
                ]),
                'sequence' => 11,
            ],
            [
                'code' => 'G6',
                'desc' => 'Online Abuse and Exploitation',
                'ask_instruction' => json_encode([
                    'questions' => [
                        ['question' => 'What apps/social media do you use most?'],
                        ['question' => 'How do you stay safe online?'],
                        ['question' => 'What are the warning signs that some people online are lying or are not who they say they are?'],
                        ['question' => 'Why would people say things online they would not say in person?'],
                        ['question' => 'Why might young people share a nude photo of themselves? Has someone'],
                        [
                            'question' => 'Find out if there is a history of the following:',
                            'options' => [
                                'Shared inappropriate pictures of self online',
                                'Shared nude pictures of self online',
                                'Took part in online sexual activities',
                                'Refused to go to school',
                                'Obsessively checked his/her phone',
                                'Distanced self in silence, anger or anxiety',
                                'Suddenly deleted/took time off an app he/she loved',
                                'Skipped meals, said he/she was not hungry',
                                'Sudden awareness of own body or sudden diets'
                            ]
                        ]
                    ]
                ]),
                'sequence' => 12,
            ],
            [
                'code' => 'H6',
                'desc' => 'STI: Male Urethral Discharge',
                'ask_instruction' => json_encode([
                    'questions' => [
                        ['question' => 'What is the color/characteristic of the penile discharge?'],
                        ['question' => 'Do you have pain/difficulty when you urinate?'],
                        ['question' => 'Have you had this problem before?'],
                        ['question' => 'Were you treated and did you complete the treatment?'],
                        [
                            'question' => 'Do you have any other genital problems?',
                            'options' => [
                                'Ulcers/sores',
                                'Swelling in the groin',
                                'Scrotal pain or swelling'
                            ]
                        ],
                        ['question' => 'Are you having sex?'],
                        ['question' => 'Has anybody violated or abused you?']
                    ]
                ]),
                'sequence' => 13,
            ],
            [
                'code' => 'H7',
                'desc' => 'STI: Vaginal Discharge',
                'ask_instruction' => json_encode([
                    'questions' => [
                        ['question' => 'Could you describe the vaginal discharge (without menses)?',
                            'options' => [
                                'Color: clear, white, green, grey, yellowish?',
                                'Consistency: thin, curdy, thick?',
                                'Odor: bad smell?'
                            ]
                        ],
                        ['question' => 'Do you have itching or burning sensation in the vagina? Pain/difficulty when you urinate?'],
                        ['question' => 'Have you had this problem before? Was treatment given and completed?'],
                        ['question' => 'Do you have pain in your lower abdomen?'],
                        ['question' => 'Have you had sex?'],
                        ['question' => 'If considering pregnancy: See H9: Suspected Pregnancy Algorithm.'],
                        ['question' => 'Has anybody violated or abused you in any way?']
                    ]
                ]),
                'sequence' => 14,
            ],
            [
                'code' => 'H8',
                'desc' => 'STI: HIV',
                'ask_instruction' => json_encode([
                    'questions' => [
                        ['question' => 'Were you recently tested for HIV?'],
                        ['question' => 'What test was done?'],
                        ['question' => 'Have you recently experienced the following symptoms?',
                            'options' => [
                                'Noticeable weight loss',
                                'Prolonged diarrhea',
                                'Prolonged cough',
                                'Prolonged fever',
                                'Painless purple bumps on your skin or in your mouth',
                                'White patches in your mouth',
                                'Painless swellings of your glands'
                            ]
                        ],
                        ['question' => 'Have you ever been diagnosed with tuberculosis?'],
                        ['question' => 'How many sexual partners have you had? Did your partners have other partners?'],
                        ['question' => 'Do you use a condom every time you have sex? Have you had unprotected sex in the last 72 hours?'],
                        ['question' => 'Does your partner have HIV? What medications is he taking? How long has he been taking it?'],
                        ['question' => 'Are you on PrEP (pre-exposure prophylaxis)? Have you been using PrEP correctly and consistently under the guidance of a physician?'],
                        ['question' => 'Have you used injectable drugs?'],
                        ['question' => 'Have you had the following?',
                            'options' => [
                                'Sore/ulcer on your genitals',
                                'Discharge from your vagina/penis',
                                'Scrotal pain/swelling'
                            ]
                        ]
                    ]
                ]),
                'sequence' => 15,
            ],
            [
                'code' => 'H9',
                'desc' => 'Suspected Pregnancy',
                'ask_instruction' => json_encode([
                    'questions' => [
                        ['question' => 'Do you think you could be pregnant? Why do you think so?'],
                        ['question' => 'Are you sexually active?'],
                        ['question' => 'Do you use any contraceptive method to prevent pregnancy? What method?'],
                        ['question' => 'Have you had sex since your last normal period?'],
                        ['question' => 'Since your last period, have you had sex without a condom at any time or has the condom come off or broken while having sex? Did this happen within the last five days?'],
                        ['question' => 'Since your last period, have you forgotten to take any of your pills?'],
                        ['question' => 'Have you had sex within the last five days?'],
                        ['question' => 'Ask about symptoms of pregnancy:',
                            'options' => [
                                'Late period',
                                'Nausea or vomiting in the morning',
                                'Swelling or soreness in breasts',
                                'Bleeding from vagina',
                                'Lower abdominal pain (mild/moderate/severe)'
                            ]
                        ]
                    ]
                ]),
                'sequence' => 16,
            ],
        ], ['code'], ['desc', 'ask_instruction', 'sequence']);
    }
}
