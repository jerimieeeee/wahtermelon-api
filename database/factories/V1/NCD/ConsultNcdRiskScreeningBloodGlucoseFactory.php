<?php

namespace Database\Factories\V1\NCD;

use App\Models\V1\NCD\ConsultNcdRiskAssessment;
use App\Models\V1\NCD\PatientNcd;
use App\Models\V1\Patient\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\NCD\ConsultNcdRiskScreeningBloodGlucose>
 */
class ConsultNcdRiskScreeningBloodGlucoseFactory extends Factory
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
            'consult_ncd_risk_id' => fake()->randomElement(ConsultNcdRiskAssessment::pluck('id')->toArray()),
            'patient_ncd_id' => fake()->randomElement(PatientNcd::pluck('id')->toArray()),
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'date_taken' => fake()->date($format = 'Y-m-d H:i:s', $max = 'now'),
            'fbs' => fake()->randomNumber(3, true),
            'rbs' => fake()->randomNumber(3, true),
            'raised_blood_glucose' => fake()->boolean(),
        ];
    }
}
