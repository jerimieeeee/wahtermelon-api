<?php

namespace Database\Factories\V1\GenderBasedViolence;

use App\Models\User;
use App\Models\V1\GenderBasedViolence\PatientGbvConf;
use App\Models\V1\Libraries\LibGbvConferenceMitigatingFactor;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\GenderBasedViolence\patientGbvConfMitigatingFactor>
 */
class PatientGbvConfMitigatingFactorFactory extends Factory
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
            'conference_id' => fake()->randomElement(PatientGbvConf::pluck('id')->toArray()),
            'factor_code' => fake()->randomElement(LibGbvConferenceMitigatingFactor::pluck('id')->toArray()),
            'mitigating_factor_remarks' => fake()->sentence(),
        ];
    }
}
