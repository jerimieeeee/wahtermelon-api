<?php

namespace App\Http\Requests\API\V1\GenderBasedViolence;

use Illuminate\Foundation\Http\FormRequest;

class PatientGbvConsultRequest extends FormRequest
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
            'id' => 'nullable',
            'patient_id' => 'required|exists:patients,id',
            'patient_gbv_intake_id' => 'required|exists:patient_gbv_intakes,id',
            'consult_remarks' => 'nullable',
            'provisional_cert_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'final_cert_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'cert_url' => 'nullable',
            'scheduled_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'actual_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'physician' => 'nullable',
            'date_in' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'date_due' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'date_out' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'lab_test' => 'nullable',
        ];
    }
}
