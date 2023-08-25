<?php

namespace Database\Factories\V1\FamilyPlanning;

use App\Models\User;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\FamilyPlanning\PatientFp>
 */
class PatientFpFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'no_of_living_children_desired' => fake()->numberBetween(1, 10),
            'no_of_living_children_actual' => fake()->numberBetween(1, 10),
            'birth_interval_desired' => fake()->numberBetween(1, 10),
            'average_monthly_income' => fake()->numberBetween(5000, 100000),
            'pe_remarks' => fake()->sentence(),
        ];
    }
}
