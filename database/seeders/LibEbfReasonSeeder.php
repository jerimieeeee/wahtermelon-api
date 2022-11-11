<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibEbfReason;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LibEbfReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        LibEbfReason::truncate();
        Schema::enableForeignKeyConstraints();

        LibEbfReason::upsert([
          ['desc' => 'Infant nutrition'],
          ['desc' => 'Maternal illness '],
          ['desc' => 'Infant illness'],
          ['desc' => 'Lactation and milk-pumping problems'],
          ['desc' => 'Mother returns to work'],
          ['desc' => 'Introduced water or solid food'],
        ], ['id']);
    }
}
