<?php

namespace Database\Factories\V1\Childcare;

use App\Models\V1\Childcare\PatientCcdev;
use App\Models\V1\Libraries\LibCcdevService;
use App\Models\V1\Libraries\LibVaccineStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Childcare\ConsultCcdevService>
 */
class ConsultCcdevServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'patient_id' => fake()->randomElement(PatientCcdev::pluck('patient_id')->toArray()),
            'user_id' => fake()->randomElement(PatientCcdev::pluck('user_id')->toArray()),
            'service_id' => fake()->randomElement(LibCcdevService::pluck('service_id')->toArray()),
            'service_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'status_id' => fake()->randomElement(LibVaccineStatus::pluck('status_id')->toArray()),
        ];
    }
}
