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
          ['pt_group_id' => 'cn', 'desc' => 'Consultation'],
          ['pt_group_id' => 'mc', 'desc' => 'Maternal Care'],
          ['pt_group_id' => 'cc', 'desc' => 'Child Care'],
          ['pt_group_id' => 'ab', 'desc' => 'Animal Bite'],
          ['pt_group_id' => 'ncd', 'desc' => 'Noncommunicable disease'],
          ['pt_group_id' => 'cv', 'desc' => 'COVID'],
        ], ['pt_group_id']);
    }
}
