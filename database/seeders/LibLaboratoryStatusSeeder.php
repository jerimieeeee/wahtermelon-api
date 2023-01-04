<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibLaboratoryStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibLaboratoryStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibLaboratoryStatus::upsert([
            ['code' => 'D', 'desc' => 'Done', 'sequence' => 1],
            ['code' => 'N', 'desc' => 'Not yet done', 'sequence' => 2],
            ['code' => 'X', 'desc' => 'Deferred', 'sequence' => 3],
            ['code' => 'W', 'desc' => 'Waived', 'sequence' => 4],
        ], ['code']);
    }
}
