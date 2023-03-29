<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibLaboratoryRequestStatus;
use Illuminate\Database\Seeder;

class LibLaboratoryRequestStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibLaboratoryRequestStatus::upsert([
            ['code' => 'RQ', 'desc' => 'Request', 'sequence' => 1],
            ['code' => 'RF', 'desc' => 'Refuse', 'sequence' => 2],
            ['code' => 'XX', 'desc' => 'None/Not Applicable', 'sequence' => 3],
        ], ['code']);
    }
}
