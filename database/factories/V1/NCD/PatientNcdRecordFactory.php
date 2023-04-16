<?php

namespace Database\Factories\V1\NCD;

use App\Models\V1\Libraries\LibNcdPhysicalExamAnswer;
use App\Models\V1\NCD\ConsultNcdRiskAssessment;
use App\Models\V1\NCD\PatientNcd;
use App\Models\V1\Patient\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\NCD\PatientNcdRecord>
 */
class PatientNcdRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'patient_ncd_id' => fake()->randomElement(PatientNcd::pluck('id')->toArray()),
            'consult_ncd_risk_id' => fake()->randomElement(ConsultNcdRiskAssessment::pluck('id')->toArray()),
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'consultation_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'current_medications' => fake()->sentence(),
            'palpitation_heart' => fake()->randomElement(LibNcdPhysicalExamAnswer::pluck('id')->toArray()),
            'peripheral_pulses' => fake()->randomElement(LibNcdPhysicalExamAnswer::pluck('id')->toArray()),
            'abdomen' => fake()->randomElement(LibNcdPhysicalExamAnswer::pluck('id')->toArray()),
            'heart' => fake()->randomElement(LibNcdPhysicalExamAnswer::pluck('id')->toArray()),
            'lungs' => fake()->randomElement(LibNcdPhysicalExamAnswer::pluck('id')->toArray()),
            'sensation_feet' => fake()->randomElement(LibNcdPhysicalExamAnswer::pluck('id')->toArray()),
            'other_findings' => fake()->sentence(),
            'other_infos' => fake()->sentence(),
        ];
    }
}
