<?php

namespace Database\Factories\V1\Patient;

use App\Models\User;
use App\Models\V1\Libraries\LibFpMethod;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Patient\PatientMenstrualHistory>
 */
class PatientMenstrualHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'menarche' => fake()->randomFloat(2, 2, 5),
            'lmp' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'period_duration' => fake()->randomFloat(1, 2, 5),
            'cycle' => fake()->randomFloat(1, 2, 5),
            'pads_per_day' => fake()->randomFloat(1, 2, 5),
            'onset_sexual_intercourse' => fake()->randomFloat(1, 2, 5),
            'method' => fake()->randomElement(LibFpMethod::pluck('id')->toArray()),
            'menopause' => fake()->boolean,
            'menopause_age' => fake()->randomFloat(1, 2, 5),
        ];
    }
}
