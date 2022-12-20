<?php

namespace Database\Factories\V1\NCD;

use App\Models\V1\Libraries\LibNcdRecordDiagnosis;
use App\Models\V1\NCD\ConsultNcdRiskAssessment;
use App\Models\V1\NCD\PatientNcdRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\NCD\PatientNcdRecordDiagnosis>
 */
class PatientNcdRecordDiagnosisFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'patient_ncd_record_id' => fake()->randomElement(PatientNcdRecord::pluck('id')->toArray()),
            'consult_ncd_risk_id' => fake()->randomElement(ConsultNcdRiskAssessment::pluck('id')->toArray()),
            'diagnosis_code' => fake()->randomElement(LibNcdRecordDiagnosis::pluck('id')->toArray()),
        ];
    }
}
