<?php

namespace Database\Factories\V1\Childcare;

use App\Models\User;
use App\Models\V1\Childcare\PatientCcdev;
use App\Models\V1\Libraries\LibVaccine;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ConsultCcdevVaccinesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'patient_ccdev_id' => fake()->randomElement(PatientCcdev::pluck('id')->toArray()),
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'vaccine_id' => fake()->randomElement(LibVaccine::pluck('vaccine_id')->toArray()),
            'vaccine_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'created_at' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'updated_at' => fake()->date($format = 'Y-m-d', $max = 'now'),
        ];
    }
}
