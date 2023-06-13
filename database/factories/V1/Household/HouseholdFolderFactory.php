<?php

namespace Database\Factories\V1\Household;

use App\Models\User;
use App\Models\V1\Libraries\LibResidenceClassification;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Barangay;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Household\HouseholdFolder>
 */
class HouseholdFolderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        Patient::factory()->create();

        return [
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'address' => fake()->address(),
            'barangay_code' => fake()->randomElement(Barangay::pluck('code')->toArray()),
            'residence_classification_code' => fake()->randomElement(LibResidenceClassification::pluck('code')->toArray()),
            'cct_date' => fake()->optional()->date('Y-m-d'),
            'cct_id' => fake()->optional()->randomDigit(),
        ];
    }
}
