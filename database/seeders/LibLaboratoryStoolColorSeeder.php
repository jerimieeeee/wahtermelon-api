<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibLaboratoryStoolColor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibLaboratoryStoolColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibLaboratoryStoolColor::upsert([
            ['code' => '1', 'desc' => 'Brown'],
            ['code' => '2', 'desc' => 'Black'],
            ['code' => '3', 'desc' => 'Red'],
            ['code' => '4', 'desc' => 'White/Grey'],
            ['code' => '5', 'desc' => 'Yellow'],
            ['code' => '6', 'desc' => 'Green'],
        ], ['code']);
    }
}
