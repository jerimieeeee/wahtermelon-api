<?php

namespace Database\Factories\V1\TBDots;

use App\Models\User;
use App\Models\V1\Libraries\LibTbTreatmentOutcome;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\TBDots\PatientTbHistory>
 */
class PatientTbHistoryFactory extends Factory
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
            'outcome_code' => fake()->randomElement(LibTbTreatmentOutcome::pluck('code')->toArray()),
            'treatment_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
        ];
    }
}
