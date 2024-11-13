<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibDentalService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibDentalServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibDentalService::upsert([
            ['id' => 1, 'desc' => 'Advised on exclusive breastfeeding',         'sequence' => 1],
            ['id' => 2, 'desc' => 'Atraumatic restorative treatment',           'sequence' => 2],
            ['id' => 3, 'desc' => 'Drainage of localized oral abscess',         'sequence' => 3],
            ['id' => 4, 'desc' => 'Education and counselling',                  'sequence' => 4],
            ['id' => 5, 'desc' => 'Gum treatment',                              'sequence' => 5],
            ['id' => 6, 'desc' => 'Instruction of infants oral health care',    'sequence' => 6],
            ['id' => 7, 'desc' => 'Oral examination',                           'sequence' => 7],
            ['id' => 8, 'desc' => 'Oral health education',                      'sequence' => 8],
            ['id' => 9, 'desc' => 'Oral urgent treatment',                      'sequence' => 9],
            ['id' => 10, 'desc' => 'Pit and fissure sealant',                   'sequence' => 10],
            ['id' => 11, 'desc' => 'Referral of complicated cases',             'sequence' => 11],
            ['id' => 12, 'desc' => 'Relief of pain',                            'sequence' => 12],
            ['id' => 13, 'desc' => 'Removal of unsavable teeth',                'sequence' => 13],
            ['id' => 14, 'desc' => 'Scaling',                                  'sequence' => 14],
            ['id' => 15, 'desc' => 'Supervised tooth brushing',                 'sequence' => 15],
            ['id' => 16, 'desc' => 'Temporary filling',                         'sequence' => 16],
            ['id' => 17, 'desc' => 'Topical fluoride application',              'sequence' => 17],
            ['id' => 18, 'desc' => 'Treatment of post extraction complications','sequence' => 18],
            ['id' => 19, 'desc' => 'Oral Prophylaxis',                          'sequence' => 19],
            ['id' => 20, 'desc' => 'Others',                                    'sequence' => 20]
        ], ['id']);
    }
}
