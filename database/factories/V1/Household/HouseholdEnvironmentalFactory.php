<?php

namespace Database\Factories\V1\Household;

use App\Models\User;
use App\Models\V1\Household\HouseholdFolder;
use App\Models\V1\Libraries\LibEnvironmentalResult;
use App\Models\V1\Libraries\LibEnvironmentalSewage;
use App\Models\V1\Libraries\LibEnvironmentalToiletFacility;
use App\Models\V1\Libraries\LibEnvironmentalWasteManagement;
use App\Models\V1\Libraries\LibEnvironmentalWaterType;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Household\HouseholdEnvironmental>
 */
class HouseholdEnvironmentalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'household_folder_id' => fake()->randomElement(HouseholdFolder::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'registration_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'water_type_code' => fake()->randomElement(LibEnvironmentalWaterType::pluck('code')->toArray()),
            'safety_managed_flag' => fake()->boolean(),
            'sanitation_managed_flag' => fake()->boolean(),
            'satisfaction_management_flag' => fake()->boolean(),
            'complete_sanitation_flag' => fake()->boolean(),
            'located_premises_flag' => fake()->boolean(),
            'availability_flag' => fake()->boolean(),
            'microbiological_result' => fake()->randomElement(LibEnvironmentalResult::pluck('code')->toArray()),
            'validation_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'arsenic_result' => fake()->randomElement(LibEnvironmentalResult::pluck('code')->toArray()),
            'arsenic_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'open_defecation_flag' => fake()->boolean(),
            'toilet_facility_code' => fake()->randomElement(LibEnvironmentalToiletFacility::pluck('code')->toArray()),
            'toilet_shared_flag' => fake()->boolean(),
            'sewage_code' => fake()->randomElement(LibEnvironmentalSewage::pluck('code')->toArray()),
            'waste_management_code' => fake()->randomElement(LibEnvironmentalWasteManagement::pluck('code')->toArray()),
            'remarks' => fake()->sentence(),
            'end_sanitation_flag' => fake()->boolean(),
        ];
    }
}
