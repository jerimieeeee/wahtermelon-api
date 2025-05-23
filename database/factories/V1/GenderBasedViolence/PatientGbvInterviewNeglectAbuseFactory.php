<?php

namespace Database\Factories\V1\GenderBasedViolence;

use App\Models\User;
use App\Models\V1\GenderBasedViolence\PatientGbvIntake;
use App\Models\V1\Libraries\LibGbvInfoSource;
use App\Models\V1\Libraries\LibGbvNeglects;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PatientGbvInterviewNeglectAbuseFactory extends Factory
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
            'info_source_id' => fake()->randomElement(LibGbvInfoSource::pluck('id')->toArray()),
            'neglect_abused_id' => fake()->randomElement(LibGbvNeglects::pluck('id')->toArray()),
            'neglect_abused_remarks' => fake()->sentence(),
        ];
    }
}
