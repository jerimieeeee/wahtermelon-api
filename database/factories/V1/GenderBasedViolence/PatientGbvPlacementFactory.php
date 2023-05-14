<?php

namespace Database\Factories\V1\GenderBasedViolence;

use App\Models\User;
use App\Models\V1\GenderBasedViolence\PatientGbv;
use App\Models\V1\GenderBasedViolence\PatientGbvIntake;
use App\Models\V1\Libraries\LibGbvPlacementLocation;
use App\Models\V1\Libraries\LibGbvPlacementType;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\GenderBasedViolence\PatientGbvPlacement>
 */
class PatientGbvPlacementFactory extends Factory
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
            'patient_gbv_intake_id' => fake()->randomElement(PatientGbvIntake::pluck('id')->toArray()),
            'location_id' => fake()->randomElement(LibGbvPlacementLocation::pluck('id')->toArray()),
            'home_by_cpu_flag' => fake()->boolean(),
            'home_by_other_name' => fake()->name(),
            'scheduled_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'actual_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'placement_name' => fake()->name(),
            'placement_contact_info' => fake()->phoneNumber(),
            'type_id' => fake()->randomElement(LibGbvPlacementType::pluck('id')->toArray()),
            'hospital_name' => fake()->name(),
            'hospital_ward' => fake()->name(),
            'hospital_date_in' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'hospital_date_out' => fake()->date($format = 'Y-m-d', $max = 'now'),
        ];
    }
}
