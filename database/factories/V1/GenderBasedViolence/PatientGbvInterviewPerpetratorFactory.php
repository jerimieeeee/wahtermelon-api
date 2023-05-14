<?php

namespace Database\Factories\V1\GenderBasedViolence;

use App\Models\User;
use App\Models\V1\GenderBasedViolence\PatientGbv;
use App\Models\V1\GenderBasedViolence\PatientGbvIntake;
use App\Models\V1\Libraries\LibGbvChildRelation;
use App\Models\V1\Libraries\LibGbvPerpetratorLocation;
use App\Models\V1\Libraries\LibOccupation;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\GenderBasedViolence\PatientGbvInterviewPerpetrator>
 */
class PatientGbvInterviewPerpetratorFactory extends Factory
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
            'intake_id' => fake()->randomElement(PatientGbvIntake::pluck('id')->toArray()),
            'perpetrator_unknown_flag' => fake()->boolean(),
            'gender' => substr(Str::ucfirst($gender), 0, 1),
            'perpetrator_name' => fake()->name(),
            'perpetrator_nickname' => fake()->name(),
            'perpetrator_age' => fake()->randomNumber(3, false),
            'known_to_child_flag' => fake()->boolean(),
            'relation_to_child_id' => fake()->randomElement(LibGbvChildRelation::pluck('id')->toArray()),
            'location_id' => fake()->randomElement(LibGbvPerpetratorLocation::pluck('id')->toArray()),
            'abuse_alcohol_flag' => fake()->address(),
            'abuse_drugs_flag' => fake()->boolean(),
            'abuse_drugs_remarks' => fake()->sentence(),
            'abuse_others_flag' => fake()->boolean(),
            'abuse_others_remarks' => fake()->sentence(),
            'abused_as_child_flag' => fake()->boolean(),
            'abused_as_spouse_flag' => fake()->boolean(),
            'spouse_abuser_flag' => fake()->boolean(),
            'family_violence_flag' => fake()->boolean(),
            'unknown_abused_flag' => fake()->boolean(),
            'criminal_conviction_similar_flag' => fake()->boolean(),
            'criminal_conviction_other_flag' => fake()->boolean(),
            'criminal_record_unknown_flag' => fake()->boolean(),
            'criminal_barangay_flag' => fake()->boolean(),
            'criminal_barangay_remarks' => fake()->sentence(),
            'occupation_code' => fake()->randomElement(LibOccupation::pluck('code')->toArray()),
        ];
    }
}
