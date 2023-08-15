<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibFpClientType;
use Illuminate\Database\Seeder;

class LibFpClientTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibFpClientType::upsert([
            ['code' => 'CU',           'desc' => 'Current User (Continuing User)',         'category' => 'CU',     'sequence' => '1'],
            ['code' => 'NA',           'desc' => 'New Acceptor',                           'category' => 'NA',     'sequence' => '2'],
            ['code' => 'CM',           'desc' => 'Changing Method',                        'category' => 'CU',     'sequence' => '3'],
            ['code' => 'CC',           'desc' => 'Changing Clinic',                        'category' => 'CU',     'sequence' => '4'],
            ['code' => 'RS',           'desc' => 'Restart',                                'category' => 'CU',     'sequence' => '5'],
        ], ['code']);
    }
}
