<?php

namespace App\Http\Requests\API\V1\GenderBasedViolence;

use Illuminate\Foundation\Http\FormRequest;

class PatientGbvSymptomsAnogenitalRequest extends FormRequest
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
            'patient_gbv_intake_id' => 'required|exists:patient_gbv_intakes,id',
            'anogenital_array' => 'nullable|array',
            'anogenital_array.*.historian_flag' => 'boolean',
            'anogenital_array.*.child_flag' => 'boolean',
            'anogenital_array.*.anogenital_symptoms_id' => 'nullable|exists:lib_gbv_symptoms_anogenitals,id',
            'anogenital_array.*.remarks' => 'nullable',
        ];
    }
}
