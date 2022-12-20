<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibNcdRiskScreeningUrineProtein;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LibNcdRiskScreeningUrineProteinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        LibNcdRiskScreeningUrineProtein::truncate();
        Schema::enableForeignKeyConstraints();

        LibNcdRiskScreeningUrineProtein::upsert([
          ['desc' => 'Negative'],
          ['desc' => 'Trace'],
          ['desc' => '0.3'],
          ['desc' => '1.0'],
          ['desc' => '3.0'],
          ['desc' => '>20'],
        ], ['id']);
    }
}
