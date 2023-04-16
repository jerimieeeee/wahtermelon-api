<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibMedicineDoseRegimen;
use Illuminate\Database\Seeder;

class LibMedicineDoseRegimenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibMedicineDoseRegimen::upsert([
            ['code' => 'OD', 'sequence' => 1, 'desc' => 'Once a day'],
            ['code' => 'BID', 'sequence' => 2, 'desc' => '2 x a day - Every 12 hours'],
            ['code' => 'TID', 'sequence' => 3, 'desc' => '3 x a day - Every 8 hours'],
            ['code' => 'QID', 'sequence' => 4, 'desc' => '4 x a day - Every 6 hours'],
            ['code' => 'QOD', 'sequence' => 5, 'desc' => 'Every other day'],
            ['code' => 'QHS', 'sequence' => 6, 'desc' => 'Every bedtime'],
            ['code' => 'OTH', 'sequence' => 7, 'desc' => 'Others'],
        ], ['code']);
    }
}
