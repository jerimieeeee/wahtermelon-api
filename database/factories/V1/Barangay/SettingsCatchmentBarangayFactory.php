<?php

namespace Database\Factories\V1\Barangay;

use App\Models\User;
use App\Models\V1\PSGC\Barangay;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Barangay\SettingsCatchmentBarangay>
 */
class SettingsCatchmentBarangayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'year' => fake()->year('now'),
            'barangay_code' => fake()->randomElement(Barangay::pluck('code')->toArray()),
            'population' => fake()->randomNumber(),
            'household' => fake()->randomNumber(),
            'zod' => fake()->boolean(),
        ];
    }
}
