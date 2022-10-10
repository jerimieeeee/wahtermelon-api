<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LibEbfReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lib_ebf_reasons')->delete();
        DB::table('lib_ebf_reasons')
        ->insert([
          ['desc' => 'Infant nutrition'],
          ['desc' => 'Maternal illness '],
          ['desc' => 'Infant illness'],
          ['desc' => 'Lactation and milk-pumping problems'],
          ['desc' => 'Mother returns to work'],
          ['desc' => 'Introduced water or solid food'],
        ]);
    }
}
