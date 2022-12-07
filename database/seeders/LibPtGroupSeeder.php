<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibPtGroup;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibPtGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        LibPtGroup::truncate();
        Schema::enableForeignKeyConstraints();

        LibPtGroup::upsert([
          ['id' => 'cn', 'desc' => 'Consultation'],
          ['id' => 'mc', 'desc' => 'Maternal Care'],
          ['id' => 'cc', 'desc' => 'Child Care'],
          ['id' => 'ab', 'desc' => 'Animal Bite'],
          ['id' => 'ncd', 'desc' => 'Noncommunicable disease'],
          ['id' => 'cv', 'desc' => 'COVID-19'],
        ], ['id']);
    }
}
