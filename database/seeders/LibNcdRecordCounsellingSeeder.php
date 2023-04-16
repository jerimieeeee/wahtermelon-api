<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibNcdRecordCounselling;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LibNcdRecordCounsellingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        LibNcdRecordCounselling::truncate();
        Schema::enableForeignKeyConstraints();

        LibNcdRecordCounselling::upsert([
            ['desc' => 'Smoking cessation'],
            ['desc' => 'Physical activity'],
            ['desc' => 'Alcohol intake'],
            ['desc' => 'Diet'],
            ['desc' => 'Weight control'],
            ['desc' => 'Others'],
        ], ['id']);
    }
}
