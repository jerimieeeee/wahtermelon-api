<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibNcdEyeComplaint;
use Illuminate\Database\Seeder;

class LibNcdEyeComplaintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibNcdEyeComplaint::upsert([
            ['code' => 'BLUR',    'desc' => 'Blurred (Malabo, maupal o mausok)'],
            ['code' => 'PAIN',    'desc' => 'Pain (Mahapdi, masakit o mabigat sa pakiramdam)'],
            ['code' => 'DISCH',   'desc' => 'Discharge (May muta)'],
            ['code' => 'FLOAT',   'desc' => 'Floaters (May lumulutang)'],
            ['code' => 'RED',     'desc' => 'Redness (Namumula)'],
            ['code' => 'PHOTOP',  'desc' => 'Photopsia (May kumikislap)'],
            ['code' => 'TEAR',    'desc' => 'Tearing (Pagluluha)'],
            ['code' => 'GLARE',   'desc' => 'Glare (Nasisilaw)'],
            ['code' => 'ITCH',    'desc' => 'Itchiness (Makati)'],
        ], ['code']);
    }
}
