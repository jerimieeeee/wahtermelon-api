<?php

namespace App\Http\Requests\API\V1\AnimalBite;

use Illuminate\Foundation\Http\FormRequest;

class PatientAbUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'consult_date' => 'required|date|date_format:Y-m-d|before:tomorrow',
            'exposure_date' => 'required|date|date_format:Y-m-d|before:tomorrow',
            'ab_treatment_outcome_id' => 'nullable|exists:lib_ab_outcomes,id',
            'date_outcome' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'ab_treatment_outcome_id' => 'nullable|exists:lib_ab_outcomes,id',
            'manifestations' => 'nullable',
            'date_onset' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'date_died' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'death_remarks' => 'nullable'
        ];
    }
}
