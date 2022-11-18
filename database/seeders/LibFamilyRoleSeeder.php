<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibFamilyRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibFamilyRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibFamilyRole::upsert([
            ['code' => 'MEMBER', 'desc' => 'Member of the Family'],
            ['code' => 'HEAD', 'desc' => 'Head of the Family'],
        ], ['code']);
    }
}
