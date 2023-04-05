<?php

namespace Database\Factories\V1\TBDots;

use App\Models\User;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\TBDots\PatientTbSymptom>
 */
class PatientTbSymptomFactory extends Factory
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
            'bcpain' => fake()->boolean(),
            'cough' => fake()->boolean(),
            'drest' => fake()->boolean(),
            'dexertion' => fake()->boolean(),
            'fever' => fake()->boolean(),
            'hemoptysis' => fake()->boolean(),
            'nsweats' => fake()->boolean(),
            'pedema' => fake()->boolean(),
            'wloss' => fake()->boolean(),
            'symptoms_remarks' => fake()->sentence()
        ];
    }
}
