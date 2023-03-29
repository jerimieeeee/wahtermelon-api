<?php

namespace Database\Factories\V1\Patient;

use App\Models\User;
use App\Models\V1\Libraries\LibBloodType;
use App\Models\V1\Libraries\LibCivilStatus;
use App\Models\V1\Libraries\LibEducation;
use App\Models\V1\Libraries\LibOccupation;
use App\Models\V1\Libraries\LibPwdType;
use App\Models\V1\Libraries\LibReligion;
use App\Models\V1\Libraries\LibSuffixName;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Patient>
 */
class PatientFactory extends Factory
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
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'last_name' => fake()->lastName(),
            'first_name' => fake()->firstName($gender),
            'middle_name' => $middle = fake()->lastName(),
            'suffix_name' => $gender == 'male' ? fake()->randomElement(LibSuffixName::pluck('code')->toArray()) : 'NA',
            'gender' => substr(Str::ucfirst($gender), 0, 1),
            'birthdate' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'mothers_name' => fake()->firstName('female').' '.$middle,
            'mobile_number' => fake()->phoneNumber(),
            'pwd_type_code' => fake()->randomElement(LibPwdType::pluck('code')->toArray()),
            'indegenous_flag' => fake()->boolean,
            'blood_type_code' => fake()->randomElement(LibBloodType::pluck('code')->toArray()),
            'religion_code' => fake()->randomElement(LibReligion::pluck('code')->toArray()),
            'occupation_code' => fake()->randomElement(LibOccupation::pluck('code')->toArray()),
            'education_code' => fake()->randomElement(LibEducation::pluck('code')->toArray()),
            'civil_status_code' => fake()->randomElement(LibCivilStatus::pluck('code')->toArray()),
            'consent_flag' => fake()->boolean,
        ];
    }
}
