<?php

namespace App\Http\Requests\API\V1\TBDots;

use App\Models\V1\Libraries\LibTbTreatmentOutcome;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Http\FormRequest;

class PatientTbHistoryRequest extends FormRequest
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
            'outcome_code' => 'required|exists:lib_tb_treatment_outcomes,code',
            'treatment_date' => 'required|date|date_format:Y-m-d|before:tomorrow',
        ];
    }

    public function messages()
    {
        return [
            'treatment_date.before' => 'Treatment date must not be future date.',
        ];
    }

    public function bodyParameters()
    {
        return [
            'patient_id' => [
                'description' => 'ID of patient',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'outcome_code' => [
                'description' => 'Code of Treatment outcome type library',
                'example' => fake()->randomElement(LibTbTreatmentOutcome::pluck('code')->toArray()),
            ],
            'treatment_date' => [
                'description' => 'Treatment date previous tb outcome',
                'example' => fake()->date($format = 'Y-m-d', $max = 'now'),
            ],
        ];
    }
}
