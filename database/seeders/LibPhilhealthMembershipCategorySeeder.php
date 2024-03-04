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
            ['desc' => 'FE - Private - Permanent Regular', 'philhealth_cat_id' => 'S'],
            ['desc' => 'FE - Private - Casual', 'philhealth_cat_id' => 'S'],
            ['desc' => 'FE - Private - Contract/Project Based', 'philhealth_cat_id' => 'S'],
            ['desc' => 'FE - Govt - Permanent Regular', 'philhealth_cat_id' => 'G'],
            ['desc' => 'FE - Govt - Casual', 'philhealth_cat_id' => 'G'],
            ['desc' => 'FE - Govt - Contract/Project Based', 'philhealth_cat_id' => 'G'],
            ['desc' => 'FE - Enterprise Owner', 'philhealth_cat_id' => 'S'],
            ['desc' => 'FE - Household Help/Kasambahay', 'philhealth_cat_id' => 'S'],
            ['desc' => 'FE - Family Driver', 'philhealth_cat_id' => 'S'],
            ['desc' => 'IE - Migrant Worker - Land Based', 'philhealth_cat_id' => 'NO'],
            ['desc' => 'IE - Migrant Worker - Sea Based', 'philhealth_cat_id' => 'NO'],
            ['desc' => 'IE - Informal Sector', 'philhealth_cat_id' => 'NS'],
            ['desc' => 'IE - Self Earning Individual', 'philhealth_cat_id' => 'NS'],
            ['desc' => 'IE - Filipino with Dual Citizenship', 'philhealth_cat_id' => 'NS'],
            ['desc' => 'IE - Naturalized Filipino', 'philhealth_cat_id' => 'NS'],
            ['desc' => 'IE - Citizen of other countries working/residing/studying in the Philippines', 'philhealth_cat_id' => 'NS'],
            ['desc' => 'IE - Organized Group', 'philhealth_cat_id' => 'NS'],
            ['desc' => 'Indigent - NHTS-PR', 'philhealth_cat_id' => 'I'],
            ['desc' => 'Sponsored - LGU', 'philhealth_cat_id' => 'I'],
            ['desc' => 'Sponsored - NGA', 'philhealth_cat_id' => 'I'],
            ['desc' => 'Sponsored - Others', 'philhealth_cat_id' => 'I'],
            ['desc' => 'Lifetime Member - Retiree/Pensioner', 'philhealth_cat_id' => 'P'],
            ['desc' => 'Lifetime Member - With 120 months contribution and has reached retirement age', 'philhealth_cat_id' => 'P'],
            ['desc' => 'DepEd', 'philhealth_cat_id' => 'NS'],
        ], ['desc']);
    }
}
