<?php

namespace Database\Factories\V1\GenderBasedViolence;

use App\Models\User;
use App\Models\V1\GenderBasedViolence\PatientGbv;
use App\Models\V1\GenderBasedViolence\PatientGbvIntake;
use App\Models\V1\Libraries\LibCivilStatus;
use App\Models\V1\Libraries\LibEducation;
use App\Models\V1\Libraries\LibGbvChildRelation;
use App\Models\V1\Libraries\LibOccupation;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\GenderBasedViolence\PatientGbvFamilyComposition>
 */
class PatientGbvFamilyCompositionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = fake()->randomElement(['male', 'female']);

        return [
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'patient_gbv_id' => fake()->randomElement(PatientGbv::pluck('id')->toArray()),
            'name' => fake()->name(),
            'child_relation_id' => fake()->randomElement(LibGbvChildRelation::pluck('id')->toArray()),
            'living_with_child_flag' => fake()->boolean(),
            'age' => fake()->randomNumber(3, false),
            'gender' => substr(Str::ucfirst($gender), 0, 1),
            'civil_status_code' => fake()->randomElement(LibCivilStatus::pluck('code')->toArray()),
            'employed_flag' => fake()->boolean(),
            'occupation_code' => fake()->randomElement(LibOccupation::pluck('code')->toArray()),
            'education_code' => fake()->randomElement(LibEducation::pluck('code')->toArray()),
            'weekly_income' => fake()->randomNumber(5, false),
            'school' => fake()->name(),
            'company' => fake()->name(),
            'contact_information' => fake()->phoneNumber(),
        ];
    }
}
