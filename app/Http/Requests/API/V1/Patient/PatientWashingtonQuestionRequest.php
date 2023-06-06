<?php

namespace App\Http\Requests\API\V1\Patient;

use Illuminate\Foundation\Http\FormRequest;

class PatientWashingtonQuestionRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'difficulty_seeing' => 'nullable|exists:lib_washington_disability_questions,id',
            'difficulty_hearing' => 'nullable|exists:lib_washington_disability_questions,id',
            'difficulty_walking' => 'nullable|exists:lib_washington_disability_questions,id',
            'difficulty_remembering' => 'nullable|exists:lib_washington_disability_questions,id',
            'difficulty_self_care' => 'nullable|exists:lib_washington_disability_questions,id',
            'difficulty_speaking' => 'nullable|exists:lib_washington_disability_questions,id'
        ];
    }
}
