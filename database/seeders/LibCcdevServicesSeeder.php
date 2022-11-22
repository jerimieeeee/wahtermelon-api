<?php

namespace Database\Seeders;

use App\Models\V1\Childcare\ConsultCcdevService;
use App\Models\V1\Libraries\LibCcdevService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
            ['service_id' => 'CC',      'service_name' => 'Cord Clamping',                        'order_seq' => '7',     'service_cat' => 'N'],
            ['service_id' => 'COMP',    'service_name' => 'Complimentary Feeding',                'order_seq' => '0',     'service_cat' => 'Y'],
            ['service_id' => 'DENT',    'service_name' => 'Dental Checkup',                       'order_seq' => '4',     'service_cat' => 'Y'],
            ['service_id' => 'DRY',     'service_name' => 'Drying',                               'order_seq' => '7',     'service_cat' => 'N'],
            ['service_id' => 'HEAR',    'service_name' => 'Newborn Hearing Screening',            'order_seq' => '1',     'service_cat' => 'Y'],
            ['service_id' => 'IRON',    'service_name' => 'Iron Intake',                          'order_seq' => '5',     'service_cat' => 'Y'],
            ['service_id' => 'MNP',     'service_name' => 'Received Micronutrient Powder (MNP)',  'order_seq' => '6',     'service_cat' => 'Y'],
            ['service_id' => 'MNP2',    'service_name' => 'MNP 2nd Dose',                         'order_seq' => '0',     'service_cat' => 'Y'],
            ['service_id' => 'NBS',     'service_name' => 'Newborn Screening (Referred)',         'order_seq' => '1',     'service_cat' => 'Y'],
            ['service_id' => 'NBSDONE', 'service_name' => 'Newborn Screening (Done)',             'order_seq' => '1',     'service_cat' => 'Y'],
            ['service_id' => 'NONSEPA', 'service_name' => 'Non Separation',                       'order_seq' => '7',     'service_cat' => 'N'],
            ['service_id' => 'PRX',     'service_name' => 'Prophylaxis',                          'order_seq' => '7',     'service_cat' => 'N'],
            ['service_id' => 'STS',     'service_name' => 'Skin to Skin',                         'order_seq' => '7',     'service_cat' => 'N'],
            ['service_id' => 'VITA',    'service_name' => 'Vitamin A',                            'order_seq' => '2',     'service_cat' => 'Y'],
            ['service_id' => 'VITA2',   'service_name' => 'Vitamin A 2nd Dose',                   'order_seq' => '0',     'service_cat' => 'Y'],
            ['service_id' => 'VITA3',   'service_name' => 'Vitamin A 3rd Dose',                   'order_seq' => '0',     'service_cat' => 'Y'],
            ['service_id' => 'VITK',    'service_name' => 'Vitamin K',                            'order_seq' => '7',     'service_cat' => 'N'],
            ['service_id' => 'WEIGH',   'service_name' => 'Weighing',                             'order_seq' => '7',     'service_cat' => 'N'],
            ['service_id' => 'WORM',    'service_name' => 'Deworming',                            'order_seq' => '3',     'service_cat' => 'Y'],

        ], ['service_id']);
    }
}
