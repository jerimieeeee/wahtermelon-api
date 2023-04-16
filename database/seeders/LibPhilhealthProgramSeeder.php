<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibPhilhealthProgram;
use Illuminate\Database\Seeder;

class LibPhilhealthProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibPhilhealthProgram::upsert([
            ['code' => 'kp', 'desc' => 'Konsulta'],
            ['code' => 'hf', 'desc' => 'PCB'],
            ['code' => 'mc', 'desc' => 'MCP'],
            ['code' => 'tb', 'desc' => 'TB'],
            ['code' => 'ab', 'desc' => 'Animal Bite'],
            ['code' => 'ml', 'desc' => 'Malaria'],
            ['code' => 'cv', 'desc' => 'CIU'],
        ], ['code']);
    }
}
