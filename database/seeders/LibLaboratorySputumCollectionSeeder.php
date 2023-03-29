<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibLaboratorySputumCollection;
use Illuminate\Database\Seeder;

class LibLaboratorySputumCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibLaboratorySputumCollection::upsert([
            ['code' => '1', 'desc' => 'First Collection'],
            ['code' => '2', 'desc' => 'Second Collection'],
            ['code' => '3', 'desc' => 'Third Collection'],
            ['code' => 'X', 'desc' => 'Not Applicable'],
        ], ['code']);
    }
}
