<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibPhilhealthMembershipCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LibPhilhealthMembershipCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        LibPhilhealthMembershipCategory::truncate();
        Schema::enableForeignKeyConstraints();
        LibPhilhealthMembershipCategory::upsert([
            ['desc' => 'FE - Private - Permanent Regular'],
            ['desc' => 'FE - Private - Casual'],
            ['desc' => 'FE - Private - Contract/Project Based'],
            ['desc' => 'FE - Govt - Permanent Regular'],
            ['desc' => 'FE - Govt - Casual'],
            ['desc' => 'FE - Govt - Contract/Project Based'],
            ['desc' => 'FE - Enterprise Owner'],
            ['desc' => 'FE - Household Help/Kasambahay'],
            ['desc' => 'FE - Family Driver'],
            ['desc' => 'IE - Migrant Worker - Land Based'],
            ['desc' => 'IE - Migrant Worker - Sea Based'],
            ['desc' => 'IE - Informal Sector'],
            ['desc' => 'IE - Self Earning Individual'],
            ['desc' => 'IE - Filipino with Dual Citizenship'],
            ['desc' => 'IE - Naturalized Filipino'],
            ['desc' => 'IE - Citizen of other countries working/residing/studying in the Philippines'],
            ['desc' => 'IE - Organized Group'],
            ['desc' => 'Indigent - NHTS-PR'],
            ['desc' => 'Sponsored - LGU'],
            ['desc' => 'Sponsored - NGA'],
            ['desc' => 'Sponsored - Others'],
            ['desc' => 'Lifetime Member - Retiree/Pensioner'],
            ['desc' => 'Lifetime Member - With 120 months contribution and has reached retirement age'],
            ['desc' => 'DepEd'],
        ], ['desc']);
    }
}
