<?php

namespace App\Http\Requests\API\V1\NCD;

use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Http\FormRequest;

class PatientNcdRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'date_enrolled' => 'date|date_format:Y-m-d|before:tomorrow|required',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'assessment_date' => $this->date_enrolled,
            'id' => $this->patient_ncd_id,
        ]);
    }

    public function bodyParameters()
    {
        return [
            'patient_id' => [
                'description' => 'ID of patient',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'date_enrolled' => [
                'description' => 'Enrollment date',
                'example' => fake()->date($format = 'Y-m-d', $max = 'now'),
            ],
        ];
    }
}
