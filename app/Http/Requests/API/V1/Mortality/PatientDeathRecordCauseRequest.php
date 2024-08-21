<?php

namespace App\Http\Requests\API\V1\Mortality;

use Illuminate\Foundation\Http\FormRequest;

class PatientDeathRecordCauseRequest extends FormRequest
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
            'death_record_id' => 'required|exists:patient_death_records,id',
            'patient_id' => 'required|exists:patients,id',
            'antecedent_cause' => 'nullable|exists:lib_icd10s,icd10_code',
            'underlying_cause' => 'nullable|exists:lib_icd10s,icd10_code',
        ];
    }
}
