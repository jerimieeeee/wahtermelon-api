<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibPatientSocialHistoryAnswer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LibPatientSocialHistoryAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        LibPatientSocialHistoryAnswer::truncate();
        Schema::enableForeignKeyConstraints();

        LibPatientSocialHistoryAnswer::upsert([
          ['id' => 'Y', 'desc' => 'Yes'],
          ['id' => 'N', 'desc' => 'No'],
          ['id' => 'X', 'desc' => 'Quit'],
        ], ['id']);
    }
}
