<?php

namespace Database\Factories\V1\NCD;

use App\Models\V1\Consultation\Consult;
use App\Models\V1\Libraries\LibNcdAnswerS2;
use App\Models\V1\Libraries\LibNcdEyeRefer;
use App\Models\V1\Libraries\LibNcdEyeReferProfessional;
use App\Models\V1\Libraries\LibNcdEyeVisionScreening;
use App\Models\V1\NCD\ConsultNcdRiskAssessment;
use App\Models\V1\NCD\PatientNcd;
use App\Models\V1\Patient\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\NCD\ConsultNcdRiskCasdt2>
 */
class ConsultNcdRiskCasdt2Factory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'consult_ncd_risk_id' => fake()->randomElement(ConsultNcdRiskAssessment::pluck('id')->toArray()),
            'patient_ncd_id' => fake()->randomElement(PatientNcd::pluck('id')->toArray()),
            'consult_id' => fake()->randomElement(Consult::pluck('id')->toArray()),
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),

            'eye_refer' => fake()->randomElement(LibNcdEyeRefer::pluck('code')->toArray()),
            'unaided' => fake()->randomElement(LibNcdEyeVisionScreening::pluck('code')->toArray()),
            'pinhole' => fake()->randomElement(LibNcdEyeVisionScreening::pluck('code')->toArray()),
            'improved' => fake()->randomElement(LibNcdEyeVisionScreening::pluck('code')->toArray()),
            'aided' => fake()->randomElement(LibNcdEyeVisionScreening::pluck('code')->toArray()),
            'eye_refer_prof' => fake()->randomElement(LibNcdEyeReferProfessional::pluck('code')->toArray()),
        ];
    }
}
