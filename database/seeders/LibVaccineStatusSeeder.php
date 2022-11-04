<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibVaccineStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibVaccineStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibVaccineStatus::upsert([
            ['desc' => 'Done'],
            ['desc' => 'Done Outside - Private'],
            ['desc' => 'Done Outside - Public'],
          ], ['status_id']);
      }
    }
