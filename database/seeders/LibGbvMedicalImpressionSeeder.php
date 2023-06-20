<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvMedicalImpression;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibGbvMedicalImpressionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvMedicalImpression::upsert([
            ['id' => 1, 'desc' => 'Anogenital Trauma Sexual Contact/Abuse', 'full_desc' => 'Anogenital findings are indicative of acute trauma to the (specify site) and is highly suggestive of sexual contact or sexual abuse (if disclosure of one is given).', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Anogenital Blunt Force/Penetrating Trauma', 'full_desc' => 'Anogenital findings are indicative of blunt force or penetrating trauma.', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Anogenital Hymen Trauma', 'full_desc' => 'Anogenital findings may suggest previous trauma to the hymen.', 'sequence' => 3],
            ['id' => 4, 'desc' => 'No Evident Injury But Cannot Exclude Sexual Abuse', 'full_desc' => 'No evident injury at the time of examination but medical evaluation cannot exclude sexual abuse.', 'sequence' => 4],
            ['id' => 5, 'desc' => 'No Evident Injury, Cannot Exclude Sexual Abuse, Child Molestation', 'full_desc' => 'No evident injury at the time of examination but medical evaluation cannot exclude sexual abuse. The absence of anogenital findings are to be expected in a child who describes this type of molestation.', 'sequence' => 5],
            ['id' => 6, 'desc' => 'Anogenital Trauma Perineum, Suggestive of Sexual Contact/Abuse', 'full_desc' => 'Anogenital findings are indicative of acute trauma to the perineum and is highly suggestive of sexual contact or sexual abuse (if a disclosure of one is given).', 'sequence' => 6],
            ['id' => 7, 'desc' => 'Anogenital  Blunt Force/Penetrating Trauma to the Anus', 'full_desc' => 'Anogenital findings are indicative of blunt force or penetrating trauma to the anus.', 'sequence' => 7],
            ['id' => 8, 'desc' => 'Anogenital Previous Anal Penetration.', 'full_desc' => 'Anogenital findings may suggest previous anal penetration.', 'sequence' => 8],
            ['id' => 9, 'desc' => 'No evident injury at the time of examination.', 'full_desc' => 'No evident injury at the time of examination.', 'sequence' => 9],
            ['id' => 10, 'desc' => 'Medical evaluation is diagnostic of sexual contact or sexual abuse.', 'full_desc' => 'Medical evaluation is diagnostic of sexual contact or sexual abuse.', 'sequence' => 10],
            ['id' => 11, 'desc' => 'Infection Confirms Mucosal Contact, Likely Due to Sexual Contact/Abuse', 'full_desc' => 'The presence of (cite infection) confirms mucosal contact with infected and infective bodily secretions, most likely due to sexual contact or sexual abuse.', 'sequence' => 11],
            ['id' => 12, 'desc' => 'Anogenital Sexual Contact/Abuse', 'full_desc' => 'Anogenital findings may suggest sexual contact or sexual abuse.', 'sequence' => 12],
            ['id' => 13, 'desc' => 'Other Suggestive Findings', 'full_desc' => 'Other Suggestive Findings', 'sequence' => 13]
        ], ['id']);
    }
}
