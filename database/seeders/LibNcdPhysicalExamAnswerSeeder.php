<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibNcdPhysicalExamAnswer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LibNcdPhysicalExamAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        LibNcdPhysicalExamAnswer::truncate();
        Schema::enableForeignKeyConstraints();

        LibNcdPhysicalExamAnswer::upsert([
          ['desc' => 'Normal'],
          ['desc' => 'Abnormal'],
        ], ['id']);
    }
}
