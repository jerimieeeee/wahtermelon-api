<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibNcdEyeRefer;
use Illuminate\Database\Seeder;

class LibNcdEyeReferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibNcdEyeRefer::upsert([
            ['code' => 'INJURY',    'desc' => 'Eye Injury'],
            ['code' => 'FOREIGN',    'desc' => 'Foreign Body'],
        ], ['code']);
    }
}
