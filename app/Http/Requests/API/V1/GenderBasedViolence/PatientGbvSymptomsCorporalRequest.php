<?php

namespace App\Http\Requests\API\V1\GenderBasedViolence;

use Illuminate\Foundation\Http\FormRequest;

class PatientGbvSymptomsCorporalRequest extends FormRequest
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
            'patient_gbv_intake_id' => 'required|exists:patient_gbv_intakes,id',
            'corporal_array' => 'required|array',
            'corporal_array.*.info_source_id' => 'required|exists:lib_gbv_info_sources,id',
            'corporal_array.*.corporal_symptoms_id' => 'required|exists:lib_gbv_symptoms_corporals,id',
            'corporal_array.*.remarks' => 'nullable',
        ];
    }
}
