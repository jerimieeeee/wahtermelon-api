<?php

namespace App\Http\Requests\API\V1\NCD;

use App\Models\V1\Consultation\Consult;
use App\Models\V1\Libraries\LibNcdAnswerS2;
use App\Models\V1\NCD\ConsultNcdRiskAssessment;
use App\Models\V1\NCD\PatientNcd;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Http\FormRequest;

class ConsultNcdRiskQuestionnaireRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'consult_ncd_risk_id' => 'required|exists:consult_ncd_risk_assessment,id',
            'patient_ncd_id' => 'required|exists:patient_ncd,id',
            'consult_id' => 'required|exists:consults,id',
            'patient_id' => 'required|exists:patients,id',
            'question1' => 'required|exists:lib_ncd_answer_s2,id',
            'question2' => 'required|exists:lib_ncd_answer_s2,id',
            'question3' => 'required|exists:lib_ncd_answer_s2,id',
            'question4' => 'required|exists:lib_ncd_answer_s2,id',
            'question5' => 'required|exists:lib_ncd_answer_s2,id',
            'question6' => 'required|exists:lib_ncd_answer_s2,id',
            'question7' => 'required|exists:lib_ncd_answer_s2,id',
            'question8' => 'required|exists:lib_ncd_answer_s2,id',
            'angina_heart_attack' => 'required|exists:lib_ncd_answer_s2,id',
            'stroke_tia' => 'required|exists:lib_ncd_answer_s2,id',
        ];
    }

    public function bodyParameters()
    {
        return [
            'consult_ncd_risk_id' => [
                'description' => 'ID of ncd risk assessment',
                'example' => fake()->randomElement(ConsultNcdRiskAssessment::pluck('id')->toArray()),
            ],
            'patient_ncd_id' => [
                'description' => 'ID of patient ncd',
                'example' => fake()->randomElement(PatientNcd::pluck('id')->toArray()),
            ],
            'consult_id' => [
                'description' => 'ID of consult',
                'example' => fake()->randomElement(Consult::pluck('id')->toArray()),
            ],
            'patient_id' => [
                'description' => 'ID of patient',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'question1' => [
                'description' => 'Question 1',
                'example' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            ],
            'question2' => [
                'description' => 'Question 2',
                'example' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            ],
            'question3' => [
                'description' => 'Question 3',
                'example' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            ],
            'question4' => [
                'description' => 'Question 4',
                'example' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            ],
            'question5' => [
                'description' => 'Question 5',
                'example' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            ],
            'question6' => [
                'description' => 'Question 6',
                'example' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            ],
            'question7' => [
                'description' => 'Question 7',
                'example' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            ],
            'question8' => [
                'description' => 'Question 8',
                'example' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            ],
            'angina_heart_attack' => [
                'description' => 'Angina or Heart attack?',
                'example' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            ],
            'stroke_tia' => [
                'description' => 'Stroke or Transient Ischemic Attack',
                'example' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            ],
        ];
    }
}
