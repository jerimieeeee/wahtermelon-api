<?php

namespace Database\Factories\V1\Patient;

use App\Models\User;
use App\Models\V1\Libraries\LibPatientSocialHistoryAnswer;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Patient\PatientSocialHistory>
 */
class PatientSocialHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'smoking' => fake()->randomElement(LibPatientSocialHistoryAnswer::pluck('id')->toArray()),
            'pack_per_year' => fake()->randomFloat(2, 2, 5),
            'alcohol' => fake()->randomElement(LibPatientSocialHistoryAnswer::pluck('id')->toArray()),
            'bottles_per_day' => fake()->randomFloat(2, 2, 5),
            'illicit_drugs' => fake()->randomElement(LibPatientSocialHistoryAnswer::pluck('id')->toArray()),
        ];
    }
}
