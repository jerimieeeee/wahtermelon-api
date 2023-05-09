<?php

namespace Database\Factories\V1\NCD;

use App\Models\V1\Patient\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\NCD\PatientNcd>
 */
class PatientNcdFactory extends Factory
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
            'date_enrolled' => fake()->date($format = 'Y-m-d H:i:s', $max = 'now'),
        ];
    }
}
