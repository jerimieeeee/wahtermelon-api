<?php

namespace App\Http\Requests\API\V1\Consultation;

use App\Models\V1\Consultation\Consult;
use App\Models\V1\Libraries\LibGeneralSurvey;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Http\FormRequest;

class ConsultNotesRequest extends FormRequest
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
            'consult_id' => 'required|exists:consults,id',
            'complaint' => 'nullable',
            'history' => 'nullable',
            'physical_exam' => 'nullable',
            'idx_remarks' => 'nullable',
            'fdx_remarks' => 'nullable',
            'plan' => 'nullable',
            'general_survey_code' => 'nullable|exists:lib_general_surveys,code',
            'general_survey_remarks' => 'nullable',
        ];
    }

    public function bodyParameters()
    {
        return [
            'consult_id' => [
                'description' => 'ID of consult.',
                'example' => fake()->randomElement(Consult::pluck('id')->toArray()),
            ],
            'patient_id' => [
                'description' => 'ID of patient.',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'complaint' => [
                'description' => 'remarks of consult_notes_complaint',
                'is_pregnant' => fake()->sentence(),
            ],
            'history' => [
                'description' => 'remarks of patient_history',
                'consult_done' => fake()->sentence(),
            ],
            'physicl_exam' => [
                'description' => 'remarks of consult_notes_pes',
                'example' => fake()->sentence(),
            ],
            'idx_remarks' => [
                'description' => 'remarks of initial diagnosis',
                'example' => fake()->sentence(),
            ],
            'fdx_remarks' => [
                'description' => 'remarks of final diagnosis',
                'example' => fake()->sentence(),
            ],
            'plan' => [
                'description' => 'remarks of treatment plan',
                'example' => fake()->sentence(),
            ],
            'general_survey_code' => [
                'description' => 'code of general survey library.',
                'example' => fake()->randomElement(LibGeneralSurvey::pluck('code')->toArray()),
            ],
            'general_survey_remarks' => [
                'description' => 'remarks of general survey',
                'example' => fake()->sentence(),
            ],
        ];
    }
}
