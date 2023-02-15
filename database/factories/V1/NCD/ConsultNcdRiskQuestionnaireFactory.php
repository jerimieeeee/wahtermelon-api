<?php

namespace Database\Factories\V1\NCD;

use App\Models\V1\Consultation\Consult;
use App\Models\V1\Libraries\LibNcdAnswerS2;
use App\Models\V1\NCD\ConsultNcdRiskAssessment;
use App\Models\V1\NCD\PatientNcd;
use App\Models\V1\Patient\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\NCD\ConsultNcdRiskQuestionnaire>
 */
class ConsultNcdRiskQuestionnaireFactory extends Factory
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
            'consult_id' => fake()->randomElement(Consult::pluck('id')->toArray()),
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'question1' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            'question2' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            'question3' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            'question4' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            'question5' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            'question6' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            'question7' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            'question8' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            'angina_heart_attack' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            'stroke_tia' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
        ];
    }
}
