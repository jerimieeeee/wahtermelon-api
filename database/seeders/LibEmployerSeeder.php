<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibEmployer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibEmployerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibEmployer::upsert([
            ['code' => 'LGU', 'desc' => 'LGU-Hired'],
            ['code' => 'DOH', 'desc' => 'DOH-Hired'],
        ], ['code']);
    }
}
