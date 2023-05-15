<?php

namespace Database\Factories\V1\GenderBasedViolence;

use App\Models\User;
use App\Models\V1\GenderBasedViolence\PatientGbvIntake;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\GenderBasedViolence\PatientGbvInterviewSummary>
 */
class PatientGbvInterviewSummaryFactory extends Factory
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
            'intake_id' => fake()->randomElement(PatientGbvIntake::pluck('id')->toArray()),
            'interview_datetime' => fake()->dateTime($format = 'Y-m-d H:i:s', $max = 'now'),
            'interview_place' => fake()->address(),
            'alleged_perpetrator' => fake()->name(),
            'interview_notes' => fake()->sentence(),
        ];
    }
}
