<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\LibVaccineSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            LibBloodTypeSeeder::class,
            LibCivilStatusSeeder::class,
            LibEducationSeeder::class,
            LibPwdTypeSeeder::class,
            LibReligionSeeder::class,
            LibSuffixNameSeeder::class,
            LibOccupationCategorySeeder::class,
            LibOccupationSeeder::class,
            LibVaccineSeeder::class,
        ]);
    }
}
