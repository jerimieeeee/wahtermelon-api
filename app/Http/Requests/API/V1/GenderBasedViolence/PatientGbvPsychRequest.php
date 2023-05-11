<?php

namespace App\Http\Requests\API\V1\GenderBasedViolence;

use Illuminate\Foundation\Http\FormRequest;

class PatientGbvPsychRequest extends FormRequest
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
            'patient_gbv_id' => 'required|exists:patient_gbvs,id',
            'scheduled_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'actual_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'md_name' => 'nullable',
            'participant_id' => 'required|exists:lib_gbv_psych_participants,id',
        ];
    }
}
