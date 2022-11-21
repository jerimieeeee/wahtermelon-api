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
            ['desc' => 'Active'],
            ['desc' => 'Cancelled'],
            ['desc' => 'Transferred'],
        ], ['desc']);
    }
}
