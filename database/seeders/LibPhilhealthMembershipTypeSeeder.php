<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibPhilhealthMembershipType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibPhilhealthMembershipTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibPhilhealthMembershipType::upsert([
            ['id' => 'MM', 'desc' => 'Member'],
            ['id' => 'DD', 'desc' => 'Dependent'],
            ['id' => 'NM', 'desc' => 'Non-Member']
        ], ['id']);
    }
}
