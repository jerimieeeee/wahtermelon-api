<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibVaccineStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LibVaccineStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        LibVaccineStatus::truncate();
        Schema::enableForeignKeyConstraints();

        LibVaccineStatus::upsert([
            ['desc' => 'Done'],
            ['desc' => 'Done Outside - Private'],
            ['desc' => 'Done Outside - Public'],
          ], ['status_id']);
      }
    }
