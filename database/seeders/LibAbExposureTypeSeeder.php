<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibAbExposureType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibAbExposureTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibAbExposureType::upsert([
            ['code' => 'BATS',      'category' => 'ce3', 'desc' => 'EXPOSURE TO BATS', 'icd10' => 'Z20.3', 'sequence' => 1],
            ['code' => 'CASUAL',    'category' => 'ce1', 'desc' => 'CASUAL CONTACT AND ROUTINE DELIVERY OF HEALTH CARE TO PATIENT WITH SIGNS AND SYPTOMS OF RABIES', 'icd10' => null, 'sequence' => 2],
            ['code' => 'CONTAM',    'category' => 'ce3', 'desc' => 'CONTAMINATION OF MUCOUS MEMBRANES OR OPEN SKIN LESIONS WITH BODY FLUIDS THROUGH SPLATTERING AND MOUTH-TOMOUTH RESUCITATION', 'icd10' => 'T62.8', 'sequence' => 3],
            ['code' => 'EXPOSE',    'category' => 'ce1', 'desc' => 'EXPOSURE TO PATIENT WITH SIGNS AND SYMPTOMS OF RABIES BY SHARING OF EATING OR DRINKING UTENSILS', 'icd10' => null, 'sequence' => 4],
            ['code' => 'FEED',      'category' => 'ce1', 'desc' => 'FEEDING/TOUCHING AN ANIMAL', 'icd10' => null, 'sequence' => 5],
            ['code' => 'INGESTION', 'category' => 'ce3', 'desc' => 'INGESTION OF RAW INFECTED MEAT', 'icd10' => 'T62.8', 'sequence' => 6],
            ['code' => 'LICK',      'category' => 'ce1', 'desc' => 'LICKING OF INTACT SKIN', 'icd10' => null, 'sequence' => 7],
            ['code' => 'MINOR',     'category' => 'ce2', 'desc' => 'MINOR /SUPERFICIAL SCRATCHES/ABRASIONS WITHOUT BLEEDING, INCLUDING THOSE INDUCED TO BLEED', 'icd10' => null, 'sequence' => 8],
            ['code' => 'NIBB',      'category' => 'ce2', 'desc' => 'NIBBLING OF UNCOVERED SKIN WITH OR WITHOUT BRUISING/HEMATOMA', 'icd10' => null, 'sequence' => 9],
            ['code' => 'TRANS',     'category' => 'ce3', 'desc' => 'TRANSDERMAL BITES (PUNCTURE WOUNDS, LACERATIONS, AVULSIONS) OR SCRATCHES/ABRASIONS WITH SPONTANEOUS BLEEDING', 'icd10' => 'T62.8', 'sequence' => 10],
            ['code' => 'UNPROC',    'category' => 'ce3', 'desc' => 'UNPROTECTED HANDLING OF INFECTED CARCASS', 'icd10' => 'Z20.3', 'sequence' => 11]
        ], ['code']);
    }
}
