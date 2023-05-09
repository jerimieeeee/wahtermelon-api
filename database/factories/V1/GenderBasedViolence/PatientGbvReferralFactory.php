<?php

namespace Database\Factories\V1\GenderBasedViolence;

use App\Models\User;
use App\Models\V1\GenderBasedViolence\PatientGbv;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\GenderBasedViolence\PatientGbvReferral>
 */
class PatientGbvReferralFactory extends Factory
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
            'patient_gbv_id' => fake()->randomElement(PatientGbv::pluck('id')->toArray()),
            'referral_facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'referral_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'referral_reason' => fake()->sentence(),
            'service_remarks' => fake()->sentence(),
        ];
    }
}
