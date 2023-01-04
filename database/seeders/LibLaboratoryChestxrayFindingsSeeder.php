<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibLaboratoryChestxrayFindings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibLaboratoryChestxrayFindingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibLaboratoryChestxrayFindings::upsert([
            ['code' => '1', 'desc' => 'NORMAL'],
            ['code' => '2', 'desc' => 'PNEUMONIA'],
            ['code' => '3', 'desc' => 'PTB/KOCHS'],
            ['code' => '4', 'desc' => 'PLEURAL EFFUSION'],
            ['code' => '5', 'desc' => 'PNEUMOTHORAX'],
            ['code' => '6', 'desc' => 'EMPHYSEMA'],
            ['code' => '7', 'desc' => 'CHRONIC BRONCHITIS'],
            ['code' => '8', 'desc' => 'BRONCHIECTASIS'],
            ['code' => '9', 'desc' => 'ACUTE BRONCHITIS'],
            ['code' => '10', 'desc' => 'BRONCHIOLITIS'],
            ['code' => '11', 'desc' => 'CHRONIC OBSTRUCTIVE PULMONARY DISEASE'],
            ['code' => '12', 'desc' => 'PULMONARY MASS'],
            ['code' => '99', 'desc' => 'OTHERS'],
        ], ['code']);
    }
}
