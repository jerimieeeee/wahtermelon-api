<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibNcdRiskScreeningUrineKetones;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LibNcdRiskScreeningUrineKetonesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        LibNcdRiskScreeningUrineKetones::truncate();
        Schema::enableForeignKeyConstraints();

        LibNcdRiskScreeningUrineKetones::upsert([
            ['desc' => 'Negative'],
            ['desc' => '0.5'],
            ['desc' => '1.5'],
            ['desc' => '4.0'],
            ['desc' => '8.0'],
            ['desc' => '16'],
        ], ['id']);
    }
}
