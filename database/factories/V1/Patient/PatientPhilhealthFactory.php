<?php

namespace Database\Factories\V1\Patient;

use App\Models\User;
use App\Models\V1\Libraries\LibMemberRelationship;
use App\Models\V1\Libraries\LibPhilhealthEnlistmentStatus;
use App\Models\V1\Libraries\LibPhilhealthMembershipCategory;
use App\Models\V1\Libraries\LibPhilhealthMembershipType;
use App\Models\V1\Libraries\LibPhilhealthPackageType;
use App\Models\V1\Libraries\LibSuffixName;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Patient\PatientPhilhealth>
 */
class PatientPhilhealthFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        Patient::factory()->create();
        $gender = fake()->randomElement(['male', 'female']);
        $membershipType = fake()->randomElement(LibPhilhealthMembershipType::pluck('id')->toArray());

        return [
            'philhealth_id' => fake()->numerify('############'),
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'enlistment_date' => fake()->dateTimeInInterval('-'.fake()->numberBetween(1, 7).' week')->format('Y-m-d'),
            'effectivity_year' => fake()->year('now'),
            'enlistment_status_id' => fake()->randomElement(LibPhilhealthEnlistmentStatus::pluck('id')->toArray()),
            'package_type_id' => fake()->randomElement(LibPhilhealthPackageType::pluck('id')->toArray()),
            'membership_type_id' => $membershipType,
            'membership_category_id' => fake()->randomElement(LibPhilhealthMembershipCategory::pluck('id')->toArray()),
            'member_pin' => $membershipType == 'DD' ? fake()->numerify('############') : null,
            'member_last_name' => $membershipType == 'DD' ? fake()->lastName() : null,
            'member_first_name' => $membershipType == 'DD' ? fake()->firstName($gender) : null,
            'member_middle_name' => $membershipType == 'DD' ? fake()->optional()->lastName() : null,
            'member_suffix_name' => $membershipType == 'DD' && $gender == 'male' ? fake()->randomElement(LibSuffixName::pluck('code')->toArray()) : ($membershipType == 'DD' && $gender == 'female' ? 'NA' : null),
            'member_birthdate' => $membershipType == 'DD' ? fake()->dateTimeInInterval('-'.fake()->numberBetween(1, 7).' week')->format('Y-m-d') : null,
            'member_gender' => $membershipType == 'DD' ? substr(Str::ucfirst($gender), 0, 1) : null,
            'member_relation_id' => $membershipType == 'DD' ? fake()->randomElement(LibMemberRelationship::pluck('id')->toArray()) : null,
            'employer_pin' => fake()->numerify('############'),
            'employer_name' => fake()->company(),
            'employer_address' => fake()->address(),
        ];
    }
}
