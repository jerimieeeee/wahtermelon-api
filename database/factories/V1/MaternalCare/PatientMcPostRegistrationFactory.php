<?php

namespace Database\Factories\V1\MaternalCare;

use App\Models\User;
use App\Models\V1\Libraries\LibMcAttendant;
use App\Models\V1\Libraries\LibMcDeliveryLocation;
use App\Models\V1\Libraries\LibMcOutcome;
use App\Models\V1\PSGC\Barangay;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\MaternalCare\PatientMcPostRegistration>
 */
class PatientMcPostRegistrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'post_registration_date' => today()->format('Y-m-d'),
            'admission_date' => fake()->dateTimeInInterval('-'.fake()->numberBetween(1, 7).' week')->format('Y-m-d H:i:s'),
            'discharge_date' => fake()->dateTimeInInterval('-'.fake()->numberBetween(1, 7).' week')->format('Y-m-d H:i:s'),
            'delivery_date' => fake()->dateTimeInInterval('-'.fake()->numberBetween(1, 7).' week')->format('Y-m-d H:i:s'),
            'delivery_location_code' => fake()->randomElement(LibMcDeliveryLocation::pluck('code')->toArray()),
            'barangay_code' => fake()->randomElement(Barangay::pluck('psgc_10_digit_code')->toArray()),
            'gravidity' => 1,
            'parity' => 1,
            'full_term' => 1,
            'preterm' => 0,
            'abortion' => 0,
            'livebirths' => 0,
            'outcome_code' => fake()->randomElement(LibMcOutcome::pluck('code')->toArray()),
            'healthy_baby' => fake()->boolean(),
            'birth_weight' => 2,
            'attendant_code' => fake()->randomElement(LibMcAttendant::pluck('code')->toArray()),
            'breastfeeding' => 0,
            'end_pregnancy' => fake()->boolean(),
            'postpartum_remarks' => fake()->sentence(),
        ];
    }
}
