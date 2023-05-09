<?php

namespace Database\Factories\V1\TBDots;

use App\Models\User;
use App\Models\V1\Libraries\LibTbOutcomeReason;
use App\Models\V1\Libraries\LibTbTreatmentOutcome;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\TBDots\PatientTb>
 */
class PatientTbFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        Patient::factory()->create();

        return [
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'tb_treatment_outcome_code' => fake()->randomElement(LibTbTreatmentOutcome::pluck('code')->toArray()),
            'lib_tb_outcome_reason_id' => fake()->randomElement(LibTbOutcomeReason::pluck('id')->toArray()),
            'outcome_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'treatment_done' => fake()->boolean,
            'outcome_remarks' => fake()->sentence(),
        ];
    }
}
