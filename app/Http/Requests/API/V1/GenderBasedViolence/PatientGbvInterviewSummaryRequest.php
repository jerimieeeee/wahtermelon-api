<?php

namespace App\Http\Requests\API\V1\GenderBasedViolence;

use Illuminate\Foundation\Http\FormRequest;

class PatientGbvInterviewSummaryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
            'intake_id' => 'required|exists:patient_gbv_intakes,id',
            'interview_datetime' => 'nullable|date|date_format:Y-m-d H:i:s|before:tomorrow',
            'interview_place' => 'nullable',
            'alleged_perpetrator' => 'nullable',
            'interview_notes' => 'nullable',
        ];
    }
}
