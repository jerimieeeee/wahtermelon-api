<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibCcdevService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LibCcdevServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        LibCcdevService::truncate();
        Schema::enableForeignKeyConstraints();

        LibCcdevService::upsert([
            ['service_id' => 'CC',      'service_name' => 'Cord Clamping',                        'order_seq' => '1',     'essential' => 'Y'],
            // ['service_id' => 'COMP',    'service_name' => 'Complimentary Feeding',                'order_seq' => '0',     'essential' => 'N'],
            ['service_id' => 'DRY',     'service_name' => 'Drying',                               'order_seq' => '2',     'essential' => 'Y'],
            ['service_id' => 'NONSEPA', 'service_name' => 'Non Separation',                       'order_seq' => '3',     'essential' => 'Y'],
            ['service_id' => 'PRX',     'service_name' => 'Prophylaxis',                          'order_seq' => '4',     'essential' => 'Y'],
            ['service_id' => 'STS',     'service_name' => 'Skin to Skin',                         'order_seq' => '5',     'essential' => 'Y'],
            ['service_id' => 'VITK',    'service_name' => 'Vitamin K',                            'order_seq' => '6',     'essential' => 'Y'],
            ['service_id' => 'WEIGH',   'service_name' => 'Weighing',                             'order_seq' => '7',     'essential' => 'Y'],
            ['service_id' => 'NBSDONE', 'service_name' => 'Newborn Screening (Done)',             'order_seq' => '8',     'essential' => 'N'],
            ['service_id' => 'NBS',     'service_name' => 'Newborn Screening (Referred)',         'order_seq' => '9',     'essential' => 'N'],
            ['service_id' => 'HEAR',    'service_name' => 'Newborn Hearing Screening',            'order_seq' => '10',     'essential' => 'N'],
            ['service_id' => 'IRON',    'service_name' => 'Iron Intake',                          'order_seq' => '11',     'essential' => 'N'],
            ['service_id' => 'VITA',    'service_name' => 'Vitamin A 1st Dose',                   'order_seq' => '12',     'essential' => 'N'],
            ['service_id' => 'VITA2',   'service_name' => 'Vitamin A 2nd Dose',                   'order_seq' => '13',     'essential' => 'N'],
            ['service_id' => 'VITA3',   'service_name' => 'Vitamin A 3rd Dose',                   'order_seq' => '14',     'essential' => 'N'],
            ['service_id' => 'MNP',     'service_name' => 'Micronutrient Powder (MNP) 1st Dose',  'order_seq' => '15',     'essential' => 'N'],
            ['service_id' => 'MNP2',    'service_name' => 'Micronutrient Powder (MNP) 2nd Dose',  'order_seq' => '16',     'essential' => 'N'],
            // ['service_id' => 'SUPP',    'service_name' => 'Supplementary Feeding',                'order_seq' => '0',     'essential' => 'N'],
            ['service_id' => 'RSUPP',    'service_name' => 'Ready to use Supplementary Food',     'order_seq' => '17',     'essential' => 'N'],
            ['service_id' => 'RTUPP',    'service_name' => 'Ready to use Therapeutic Food',       'order_seq' => '18',     'essential' => 'N'],
            ['service_id' => 'WORM',    'service_name' => 'Deworming',                            'order_seq' => '19',     'essential' => 'N'],
            ['service_id' => 'DENT',    'service_name' => 'Dental Checkup',                       'order_seq' => '20',     'essential' => 'N'],
        ], ['service_id']);
    }
}
