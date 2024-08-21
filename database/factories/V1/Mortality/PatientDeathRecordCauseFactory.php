<?php

namespace Database\Factories\V1\Mortality;

use App\Models\User;
use App\Models\V1\Libraries\LibIcd10;
use App\Models\V1\Libraries\LibMortalityDeathPlace;
use App\Models\V1\Libraries\LibMortalityDeathType;
use App\Models\V1\Mortality\PatientDeathRecordCauses;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Barangay;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PatientDeathRecordCauseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'death_record_id' => fake()->randomElement(PatientDeathRecordCauses::pluck('id')->toArray()),
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'antecedent_cause' => fake()->randomElement(LibIcd10::pluck('icd10_code')->toArray()),
            'underlying_cause' => fake()->randomElement(LibIcd10::pluck('icd10_code')->toArray()),
        ];
    }
}
