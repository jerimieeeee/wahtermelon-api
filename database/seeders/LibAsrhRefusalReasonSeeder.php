<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibAsrhRefusalReason;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibAsrhRefusalReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibAsrhRefusalReason::upsert([
            ['id' => 1, 'desc' => 'Trust issues'],
            ['id' => 2, 'desc' => 'Fear of judgement'],
            ['id' => 3, 'desc' => 'Under estimation of the Tools importance'],
            ['id' => 99, 'desc' => 'Others, specify'],
        ], ['id']);
    }
}
