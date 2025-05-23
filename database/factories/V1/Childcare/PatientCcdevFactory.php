<?php

namespace Database\Factories\V1\Childcare;

use App\Models\User;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PatientCcdev>
 */
class PatientCcdevFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        Patient::factory()->create();

        return [
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'birth_weight' => fake()->randomFloat(2, 2, 5),
            'ccdev_ended' => fake()->boolean,
            'mothers_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'admission_date' => fake()->date($format = 'Y-m-d H:i:s', $max = 'now'),
            'discharge_date' => fake()->date($format = 'Y-m-d H:i:s', $max = 'now'),
            'nbs_filter' => fake()->regexify('[0-9]{10}'),
        ];
    }
}
