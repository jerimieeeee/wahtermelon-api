<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibLaboratoryBloodInStool;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibLaboratoryBloodInStoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibLaboratoryBloodInStool::upsert([
            ['code' => 'P', 'desc' => 'Present'],
            ['code' => 'A', 'desc' => 'Absent'],
        ], ['code']);
    }
}
