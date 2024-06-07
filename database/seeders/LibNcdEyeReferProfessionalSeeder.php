<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibNcdEyeReferProfessional;
use Illuminate\Database\Seeder;

class LibNcdEyeReferProfessionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibNcdEyeReferProfessional::upsert([
            ['code' => 'IMPROVE',      'desc' => 'If VA is 20/40 to 20/100 but IMPROVES WITH PINHOLE: Refer to OPTOMETRIST'],
            ['code' => 'NOTIMPROVE',   'desc' => 'If VA is 20/40 to 20/100 but DOES NOT IMPROVE WITH PINHOLE: Refer to OPHTHALMOLOGIST'],
            ['code' => 'WORSE',        'desc' => 'If VA is 20/200 or worse: Refer to OPHTHALMOLOGIST'],
        ], ['code']);
    }
}
