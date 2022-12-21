<?php

namespace Database\Factories\V1\NCD;

use App\Models\V1\Consultation\Consult;
use App\Models\V1\Libraries\LibNcdAlcoholIntakeAnswer;
use App\Models\V1\Libraries\LibNcdAnswer;
use App\Models\V1\Libraries\LibNcdAnswerS2;
use App\Models\V1\Libraries\LibNcdClientType;
use App\Models\V1\Libraries\LibNcdLocation;
use App\Models\V1\Libraries\LibNcdSmokingAnswer;
use App\Models\V1\NCD\PatientNcd;
use App\Models\V1\Patient\Patient;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\NCD\ConsultNcdRiskAssessment>
 */
class ConsultNcdRiskAssessmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $gender = fake()->randomElement(['male', 'female']);
        return [
            'patient_ncd_id' => fake()->randomElement(PatientNcd::pluck('id')->toArray()),
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'consult_id' => fake()->randomElement(Consult::pluck('id')->toArray()),
            'location' => fake()->randomElement(LibNcdLocation::pluck('id')->toArray()),
            'client_type' => fake()->randomElement(LibNcdClientType::pluck('id')->toArray()),
            'assessment_date' => fake()->date($format = 'Y-m-d H:i:s', $max = 'now'),
            'family_hx_hypertension' => fake()->randomElement(LibNcdAnswer::pluck('id')->toArray()),
            'family_hx_stroke' => fake()->randomElement(LibNcdAnswer::pluck('id')->toArray()),
            'family_hx_heart_attack' => fake()->randomElement(LibNcdAnswer::pluck('id')->toArray()),
            'family_hx_diabetes' => fake()->randomElement(LibNcdAnswer::pluck('id')->toArray()),
            'family_hx_asthma' => fake()->randomElement(LibNcdAnswer::pluck('id')->toArray()),
            'family_hx_cancer' => fake()->randomElement(LibNcdAnswer::pluck('id')->toArray()),
            'family_hx_kidney_disease' => fake()->randomElement(LibNcdAnswer::pluck('id')->toArray()),
            'smoking' => fake()->randomElement(LibNcdSmokingAnswer::pluck('id')->toArray()),
            'alcohol_intake' => fake()->randomElement(LibNcdAlcoholIntakeAnswer::pluck('id')->toArray()),
            'excessive_alcohol_intake' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            'high_fat' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            'intake_fruits' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            'physical_activity' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            'intake_vegetables' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            'presence_diabetes' => fake()->randomElement(LibNcdAnswer::pluck('id')->toArray()),
            'diabetes_medications' => fake()->randomElement(LibNcdAnswer::pluck('id')->toArray()),
            'polyphagia' => fake()->randomElement(LibNcdAnswer::pluck('id')->toArray()),
            'polydipsia' => fake()->randomElement(LibNcdAnswer::pluck('id')->toArray()),
            'polyuria' => fake()->randomElement(LibNcdAnswer::pluck('id')->toArray()),
            'obesity' => fake()->boolean,
            'central_adiposity' => fake()->boolean,
            'bmi' => fake()->randomFloat(2, 2, 5),
            'waist_line' => fake()->randomNumber(3, true),
            'raised_bp' => fake()->boolean,
            'avg_systolic' => fake()->randomNumber(3, true),
            'avg_diastolic' => fake()->randomNumber(3, true),
            'systolic_1st' => fake()->randomNumber(3, true),
            'diastolic_1st' => fake()->randomNumber(3, true),
            'systolic_2nd' => fake()->randomNumber(3, true),
            'diastolic_2nd' => fake()->randomNumber(3, true),
            'gender' => substr(Str::ucfirst($gender), 0, 1),
            'age' => fake()->randomNumber(2, true),
        ];
    }
}
