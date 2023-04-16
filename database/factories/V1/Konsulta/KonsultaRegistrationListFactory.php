<?php

namespace Database\Factories\V1\Konsulta;

use App\Models\User;
use App\Models\V1\Libraries\LibPhilhealthMembershipType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Laravel\Passport\Passport;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Konsulta\KonsultaRegistrationList>
 */
class KonsultaRegistrationListFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        Passport::actingAs(
            User::factory()->create(['facility_code' => 'DOH000000000005173'])
        );
        $gender = fake()->randomElement(['male', 'female']);
        $membershipType = fake()->randomElement(LibPhilhealthMembershipType::pluck('id')->toArray());

        return [
            'philhealth_id' => fake()->numerify('############'),
            'last_name' => fake()->lastName(),
            'first_name' => fake()->firstName($gender),
            'middle_name' => fake()->lastName(),
            'suffix_name' => '',
            'birthdate' => fake()->dateTimeInInterval('-'.fake()->numberBetween(1, 7).' week')->format('Y-m-d'),
            'gender' => $gender,
            'membership_type_id' => $membershipType,
            'member_pin' => fake()->numerify('############'),
            'member_last_name' => fake()->lastName(),
            'member_first_name' => fake()->firstName($gender),
            'member_middle_name' => fake()->lastName(),
            'member_suffix_name' => '',
            'member_birthdate' => fake()->dateTimeInInterval('-'.fake()->numberBetween(1, 7).' week')->format('Y-m-d'),
            'member_gender' => $gender,
            'mobile_number' => '',
            'landline_number' => '',
            'member_category' => '',
            'member_category_desc' => '',
            'package_type_id' => 'K',
            'assigned_date' => fake()->dateTimeInInterval('-'.fake()->numberBetween(1, 7).' week')->format('Y-m-d'),
            'assigned_status_id' => '1',
            'effectivity_year' => '2023',
        ];
    }
}
