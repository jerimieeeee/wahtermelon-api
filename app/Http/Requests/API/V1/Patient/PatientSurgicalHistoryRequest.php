<?php

namespace App\Http\Requests\API\V1\Patient;

use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Http\FormRequest;

class PatientSurgicalHistoryRequest extends FormRequest
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
            'operation' => 'nullable',
            'operation_date' => 'nullable|date|date_format:Y-m-d',
        ];
    }

    public function bodyParameters()
    {
        return [
            'patient_id' => [
                'description' => 'ID of patient.',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'operation' => [
                'description' => 'operation of patient',
                'example' => fake()->sentence(),
            ],
            'operation_date' => [
                'description' => 'date of operation',
                'example' => fake()->date($format = 'Y-m-d', $max = 'now'),
            ],
        ];
    }
}
