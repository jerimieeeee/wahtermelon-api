<?php

namespace Database\Factories\V1\Mortality;

use App\Models\User;
use App\Models\V1\Libraries\LibIcd10;
use App\Models\V1\Libraries\LibMortalityDeathPlace;
use App\Models\V1\Libraries\LibMortalityDeathType;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Barangay;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Mortality\PatientDeathRecord>
 */
class PatientDeathRecordFactory extends Factory
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
            'date_of_death' => fake()->dateTime(),
            'age_years' => fake()->numberBetween(1, 100),
            'age_months' => fake()->numberBetween(1, 100),
            'age_days' => fake()->numberBetween(1, 100),
            'death_type' => fake()->randomElement(LibMortalityDeathType::pluck('code')->toArray()),
            'death_place' => fake()->randomElement(LibMortalityDeathPlace::pluck('code')->toArray()),
            'barangay_code' => fake()->randomElement(Barangay::pluck('psgc_10_digit_code')->toArray()),
            'immediate_cause' => fake()->randomElement(LibIcd10::pluck('icd10_code')->toArray()),
            'antecedent_cause' => fake()->randomElement(LibIcd10::pluck('icd10_code')->toArray()),
            'underlying_cause' => fake()->randomElement(LibIcd10::pluck('icd10_code')->toArray()),
            'remarks' => fake()->sentence(),
        ];
    }
}
