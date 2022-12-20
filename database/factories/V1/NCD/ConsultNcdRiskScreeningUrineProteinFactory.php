<?php

namespace Database\Factories\V1\NCD;

use App\Models\V1\Libraries\LibNcdRiskScreeningUrineProtein;
use App\Models\V1\NCD\ConsultNcdRiskAssessment;
use App\Models\V1\NCD\PatientNcd;
use App\Models\V1\Patient\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\NCD\ConsultNcdRiskScreeningUrineProtein>
 */
class ConsultNcdRiskScreeningUrineProteinFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'consult_ncd_risk_id' => fake()->randomElement(ConsultNcdRiskAssessment::pluck('id')->toArray()),
            'patient_ncd_id' => fake()->randomElement(PatientNcd::pluck('id')->toArray()),
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'date_taken' => fake()->date($format = 'Y-m-d H:i:s', $max = 'now'),
            'protein' => fake()->randomElement(LibNcdRiskScreeningUrineProtein::pluck('id')->toArray()),
            'presence_of_urine_protein' => fake()->boolean(),
        ];
    }
}
