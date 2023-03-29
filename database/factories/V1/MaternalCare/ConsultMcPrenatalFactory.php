<?php

namespace Database\Factories\V1\MaternalCare;

use App\Models\User;
use App\Models\V1\Libraries\LibMcLocation;
use App\Models\V1\Libraries\LibMcPresentation;
use App\Models\V1\MaternalCare\PatientMcPreRegistration;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\MaternalCare\ConsultMcPrenatal>
 */
class ConsultMcPrenatalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'patient_mc_id' => fake()->randomElement(PatientMcPreRegistration::pluck('patient_mc_id')->toArray()),
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'prenatal_date' => fake()->date('Y-m-d'),
            'presentation_code' => fake()->randomElement(LibMcPresentation::pluck('code')->toArray()),
            'location_code' => fake()->randomElement(LibMcLocation::pluck('code')->toArray()),
            'patient_height' => fake()->numberBetween(100, 200),
            'patient_weight' => fake()->numberBetween(40, 200),
            'bp_systolic' => fake()->numberBetween(100, 200),
            'bp_diastolic' => fake()->numberBetween(70, 100),
            'fundic_height' => fake()->numberBetween(0, 50),
            'fhr' => fake()->numberBetween(0, 50),
            'private' => fake()->boolean(),
            'remarks' => fake()->sentence(),
        ];
    }
}
