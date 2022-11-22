<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibMcService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibMcServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibMcService::upsert([
           ['id' => 'DENT', 'desc' => 'DENTAL CHECKUP'],
           ['id' => 'IRON', 'desc' => 'FERROUS SULFATE + FOLIC ACID'],
           ['id' => 'VITA', 'desc' => 'VITAMIN A'],
           ['id' => 'CALC', 'desc' => 'CALCIUM CARBONATE'],
           ['id' => 'IODN', 'desc' => 'IODINE CAPSULE'],
           ['id' => 'DWRMG', 'desc' => 'DEWORMING TABLET'],
           ['id' => 'SYP', 'desc' => 'SYPHILIS TEST'],
           ['id' => 'HEPB', 'desc' => 'HEPATITIS B TEST'],
           ['id' => 'HIV', 'desc' => 'HIV TEST'],
           ['id' => 'CBC', 'desc' => 'CBC OR Hgb & Hct COUNT TEST'],
           ['id' => 'DIBTS', 'desc' => 'GESTATIONAL DIABETES TEST'],
        ], ['id']);
    }
}
