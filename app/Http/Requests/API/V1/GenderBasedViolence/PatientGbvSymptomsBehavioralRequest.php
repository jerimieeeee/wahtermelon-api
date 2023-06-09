<?php

namespace App\Http\Requests\API\V1\GenderBasedViolence;

use Illuminate\Foundation\Http\FormRequest;

class PatientGbvSymptomsBehavioralRequest extends FormRequest
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
            'behavior_array' => 'required|array',
            'behavior_array.*.info_source_id' => 'required|exists:lib_gbv_info_sources,id',
            'behavior_array.*.behavioral_symptoms_id' => 'required|exists:lib_gbv_symptoms_behaviorals,id',
            'behavior_array.*.remarks' => 'nullable',
        ];
    }
}
