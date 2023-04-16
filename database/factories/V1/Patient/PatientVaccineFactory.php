<?php

namespace Database\Factories\V1\Patient;

use App\Models\User;
use App\Models\V1\Libraries\LibVaccine;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Patient\PatientVaccine>
 */
class PatientVaccineFactory extends Factory
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
            'vaccine_id' => fake()->randomElement(LibVaccine::pluck('vaccine_id')->toArray()),
            'vaccine_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'lot_no' => fake()->regexify('[A-Za-z0-9]{20}'),
            'batch_no' => fake()->regexify('[A-Za-z0-9]{20}'),
            'facility_name' => fake()->sentence(),
            // 'pt_group' => fake()->randomElement(['cc','mc', 'ncd']),
        ];
    }
}
