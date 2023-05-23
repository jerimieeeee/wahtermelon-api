<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibGbvSexualAbuse;
use Illuminate\Database\Seeder;

class LibGbvSexualAbuseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibGbvSexualAbuse::upsert([
            ['id' => 1, 'desc' => 'Genital contact with penis/vagina', 'sequence' => 1],
            ['id' => 2, 'desc' => 'Genital contact with finger', 'sequence' => 2],
            ['id' => 3, 'desc' => 'Genital contact with foreign object', 'sequence' => 3],
            ['id' => 4, 'desc' => 'Genital contact with other object', 'sequence' => 4],
            ['id' => 5, 'desc' => 'Anal contact with penis', 'sequence' => 5],
            ['id' => 6, 'desc' => 'Anal contact with finger', 'sequence' => 6],
            ['id' => 7, 'desc' => 'Anal contact with foreign object', 'sequence' => 7],
            ['id' => 8, 'desc' => 'Anal contact with other object', 'sequence' => 8],
            ['id' => 9, 'desc' => 'Oral copulation of genitals of victim by assailant', 'sequence' => 9],
            ['id' => 10, 'desc' => 'Oral copulation of genitals of assailant by victim', 'sequence' => 10],
            ['id' => 11, 'desc' => 'Masturbation of assailant by self', 'sequence' => 11],
            ['id' => 12, 'desc' => 'Masturbation of assailant by victim', 'sequence' => 12],
            ['id' => 13, 'desc' => 'Ejaculation', 'sequence' => 13],
            ['id' => 14, 'desc' => 'Licking or kissing', 'sequence' => 14],
            ['id' => 15, 'desc' => 'Fondling', 'sequence' => 15],
            ['id' => 16, 'desc' => 'Exhibitionism', 'sequence' => 16],
            ['id' => 17, 'desc' => 'Photos/videos taken/shown', 'sequence' => 17],
            ['id' => 18, 'desc' => 'Force or weapon used', 'sequence' => 18],
            ['id' => 19, 'desc' => 'Verbal threats', 'sequence' => 19],
            ['id' => 20, 'desc' => 'Given substance to change consciousness', 'sequence' => 20],
            ['id' => 21, 'desc' => 'Intoxicated/drunk', 'sequence' => 21],
            ['id' => 22, 'desc' => 'Child is a sex worker', 'sequence' => 22],
            ['id' => 23, 'desc' => 'Other sexual abuse', 'sequence' => 23],
        ], ['id']);
    }
}
