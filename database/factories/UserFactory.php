<?php

namespace Database\Factories;

use App\Models\V1\Libraries\LibDesignation;
use App\Models\V1\Libraries\LibEmployer;
use App\Models\V1\Libraries\LibSuffixName;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $gender = fake()->randomElement(['male', 'female']);

        return [
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'last_name' => fake()->lastName(),
            'first_name' => fake()->firstName($gender),
            'middle_name' => fake()->lastName(),
            'suffix_name' => $gender == 'male' ? fake()->randomElement(LibSuffixName::pluck('code')->toArray()) : 'NA',
            'gender' => substr(Str::ucfirst($gender), 0, 1),
            'birthdate' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'contact_number' => fake()->phoneNumber(),
            'is_active' => true,
            'email' => fake()->safeEmail(),
            'designation_code' => fake()->randomElement(LibDesignation::pluck('code')->toArray()),
            'employer_code' => fake()->randomElement(LibEmployer::pluck('code')->toArray()),
            'password' => 'Password2!',
            //'password_confirmation' => 'Password2!',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
