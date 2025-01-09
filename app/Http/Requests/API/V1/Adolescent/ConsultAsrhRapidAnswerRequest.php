<?php

namespace App\Http\Requests\API\V1\Adolescent;

use Illuminate\Foundation\Http\FormRequest;

class ConsultAsrhRapidAnswerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'answers' => ['required', 'array'],
            'patient_id' => ['required', 'exists:patients,id'],
            'answers.*.consult_asrh_rapid_id' => ['required', 'exists:consult_asrh_rapids,id'],
            'answers.*.lib_rapid_questionnaire_id' => ['required', 'exists:lib_rapid_questionnaires,id'],
            'answers.*.answer' => ['required', 'in:1,2,x'],
            'answers.*.remarks' => ['nullable', 'string'],
        ];
    }
}
