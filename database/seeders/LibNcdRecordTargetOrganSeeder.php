<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibNcdRecordTargetOrgan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LibNcdRecordTargetOrganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        LibNcdRecordTargetOrgan::truncate();
        Schema::enableForeignKeyConstraints();

        LibNcdRecordTargetOrgan::upsert([
          ['desc' => 'Left ventricular hypertrophy'],
          ['desc' => 'Hypertensive retinopathy'],
          ['desc' => 'Microalbuminuria (0.2-3g/L)'],
          ['desc' => 'Others'],
        ], ['id']);
    }
}
