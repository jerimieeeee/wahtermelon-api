<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibMedicalHistoryCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LibMedicalHistoryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        LibMedicalHistoryCategory::truncate();
        Schema::enableForeignKeyConstraints();

        LibMedicalHistoryCategory::upsert([
            ['desc' => 'Past'],
            ['desc' => 'Family'],
        ], ['id']);
    }
}
