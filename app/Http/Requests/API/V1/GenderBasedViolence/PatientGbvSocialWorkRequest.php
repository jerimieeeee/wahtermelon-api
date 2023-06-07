<?php

namespace App\Http\Requests\API\V1\GenderBasedViolence;

use Illuminate\Foundation\Http\FormRequest;

class PatientGbvSocialWorkRequest extends FormRequest
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
            'visit_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'social_worker' => 'nullable',
            'social_worker_remarks' => 'nullable',
        ];
    }
}
