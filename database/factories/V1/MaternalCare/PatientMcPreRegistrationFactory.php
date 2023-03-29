<?php

namespace Database\Factories\V1\MaternalCare;

use App\Models\User;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\MaternalCare\PatientMcPreRegistration>
 */
class PatientMcPreRegistrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'pre_registration_date' => today()->format('Y-m-d'),
            'lmp_date' => fake()->dateTimeInInterval('-'.fake()->numberBetween(1, 7).' week')->format('Y-m-d'),
            'initial_gravidity' => 0,
            'initial_parity' => 0,
            'initial_full_term' => 0,
            'initial_preterm' => 0,
            'initial_abortion' => 0,
            'initial_livebirths' => 0,
        ];
    }
}
