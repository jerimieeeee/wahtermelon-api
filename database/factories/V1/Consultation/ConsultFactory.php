<?php

namespace Database\Factories\V1\Consultation;

use App\Models\User;
use App\Models\V1\Libraries\LibPtGroup;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
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
        Patient::factory()->create();

        return [
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'consult_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'physician_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'is_pregnant' => fake()->boolean,
            'consult_done' => fake()->boolean,
            'pt_group' => fake()->randomElement(LibPtGroup::pluck('id')->toArray()),
            'authorization_transaction_code' => 'WALKEDIN',
            'walkedin_status' => true,
        ];
    }
}
