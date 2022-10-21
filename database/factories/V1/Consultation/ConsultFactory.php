<?php

namespace Database\Factories\V1\Consultation;

use App\Models\User;
use App\Models\V1\Patient\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Consultation\Consult>
 */
class ConsultFactory extends Factory
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
            'consult_end' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'physician_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'is_pregnant' => fake()->boolean,
            // 'pt_group' => fake()->randomElement(['cc','mc', 'ncd']),
            'pt_group' => null,
        ];
    }
}
