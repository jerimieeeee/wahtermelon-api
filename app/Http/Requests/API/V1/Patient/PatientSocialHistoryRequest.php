<?php

namespace App\Http\Requests\API\V1\Patient;

use App\Models\V1\Libraries\LibNcdAnswerS2;
use App\Models\V1\Libraries\LibPatientSocialHistoryAnswer;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Http\FormRequest;

class PatientSocialHistoryRequest extends FormRequest
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
            'patient_id' => 'required|exists:patients,id',
            'smoking' => 'required|exists:lib_patient_social_history_answers,id',
            'pack_per_year' => 'numeric|nullable',
            'alcohol' => 'required|exists:lib_patient_social_history_answers,id',
            'bottles_per_day' => 'numeric|nullable',
            'illicit_drugs' => 'required|exists:lib_patient_social_history_answers,id',
            'sexually_active' => 'required|exists:lib_ncd_answer_s2,id',
        ];
    }

    public function bodyParameters()
    {
        return [
            'patient_id' => [
                'description' => 'ID of Patient',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'smoking' => [
                'description' => 'ID of smoking library',
                'example' => fake()->randomElement(LibPatientSocialHistoryAnswer::pluck('id')->toArray()),
            ],
            'pack_per_year' => [
                'description' => 'pack per year of smoking',
                'example' => fake()->randomFloat(2, 2, 5),
            ],
            'alcohol' => [
                'description' => 'ID of alcohol library',
                'example' => fake()->randomElement(LibPatientSocialHistoryAnswer::pluck('id')->toArray()),
            ],
            'bottles_per_day' => [
                'description' => 'bottle per day of alcohol',
                'example' => fake()->randomFloat(2, 2, 5),
            ],
            'illicit_drugs' => [
                'description' => 'ID of illicit drugs library',
                'example' => fake()->randomElement(LibPatientSocialHistoryAnswer::pluck('id')->toArray()),
            ],
            'sexually_active' => [
                'description' => 'is patient sexually active?',
                'example' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            ],
        ];
    }
}
