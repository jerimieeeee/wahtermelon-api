<?php

namespace App\Http\Requests\API\V1\Mortality;

use Illuminate\Foundation\Http\FormRequest;

class PatientMortalityRequest extends FormRequest
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
            'patient_id' => 'required|exists:patients,id',
            'death_date' => 'required|nullable|date|date_format:Y-m-d|before:tomorrow',
            'death_type' => 'required|exists:lib_mortality_death_type,code',
            'death_place' => 'required|exists:lib_mortality_death_place,code',
            'immediate_cause' => 'nullable|exists:lib_icd10s,icd10_code',
            'antecedent_cause' => 'nullable|exists:lib_icd10s,icd10_code',
            'underlying_cause' => 'nullable|exists:lib_icd10s,icd10_code',
            'death_remarks' => 'nullable',
        ];
    }
}
