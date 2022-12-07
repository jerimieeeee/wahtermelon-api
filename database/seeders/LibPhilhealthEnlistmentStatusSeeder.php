<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibPhilhealthEnlistmentStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibPhilhealthEnlistmentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibPhilhealthEnlistmentStatus::upsert([
            ['id' => 1, 'desc' => 'Active'],
            ['id' => 2,'desc' => 'Cancelled'],
            ['id' => 3,'desc' => 'Transferred'],
        ], ['id', 'desc']);
    }
}
