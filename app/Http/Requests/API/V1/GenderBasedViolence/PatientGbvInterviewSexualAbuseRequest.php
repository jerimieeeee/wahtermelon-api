<?php

namespace App\Http\Requests\API\V1\GenderBasedViolence;

use Illuminate\Foundation\Http\FormRequest;

class PatientGbvInterviewSexualAbuseRequest extends FormRequest
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
            'patient_gbv_id' => 'required|exists:patient_gbvs,id',
            'sexual_abused_id' => 'nullable|exists:lib_gbv_sexual_abuses,id',
            'sexual_abused_remarks' => 'nullable',
        ];
    }
}
