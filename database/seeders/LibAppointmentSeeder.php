<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibAppointment;
use Illuminate\Database\Seeder;

class LibAppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibAppointment::upsert([
            ['code' => 'ATP',       'desc' => 'ATP  Follow-up',                 'module' => '',     'order_seq' => 1],
            ['code' => 'FEFF',      'desc' => 'Fecalysis Follow-up',            'module' => '',     'order_seq' => 2],
            ['code' => 'FP',        'desc' => 'Family Planning Follow-up',      'module' => '',     'order_seq' => 3],
            ['code' => 'MPFF',      'desc' => 'Multipurpose Follow-up',         'module' => '',     'order_seq' => 4],
            ['code' => 'NTPI',      'desc' => 'NTP Intensive Follow-up',        'module' => 'tb',   'order_seq' => 5],
            ['code' => 'NTPM',      'desc' => 'NTP Maintenance Follow-up',      'module' => 'tb',   'order_seq' => 6],
            ['code' => 'PCFF',      'desc' => 'Primary Complex Follow-up',      'module' => '',     'order_seq' => 7],
            ['code' => 'PMPFF',     'desc' => 'Pedia Multipurpose Follow-up',   'module' => '',     'order_seq' => 8],
            ['code' => 'PNEUM',     'desc' => 'Pneumonia 2-Day Follow-up',      'module' => '',     'order_seq' => 9],
            ['code' => 'PNEUW',     'desc' => 'Pneumonia 1-Week Follow-up',     'module' => '',     'order_seq' => 10],
            ['code' => 'POSTP',     'desc' => 'Postpartum',                     'module' => 'mc',     'order_seq' => 11],
            ['code' => 'PRENATAL',  'desc' => 'Prenatal',                       'module' => 'mc',     'order_seq' => 12],
            ['code' => 'SPT',       'desc' => 'Sputum Exam',                    'module' => '',     'order_seq' => 13],
            ['code' => 'UAFF',      'desc' => 'Urinalysis Follow-up',           'module' => '',     'order_seq' => 14],
            ['code' => 'VACC',      'desc' => 'Vaccination',                    'module' => '',     'order_seq' => 15],
        ], ['code']);
    }
}
