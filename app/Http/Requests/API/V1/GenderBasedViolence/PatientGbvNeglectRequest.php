<?php

namespace App\Http\Requests\API\V1\GenderBasedViolence;

use App\Models\V1\GenderBasedViolence\PatientGbv;
use App\Models\V1\Libraries\LibGbvNeglects;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Http\FormRequest;

class PatientGbvNeglectRequest extends FormRequest
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
            'neglect_id' => 'nullable|exists:lib_gbv_neglects,id',
        ];
    }

    public function bodyParameters()
    {
        return [
            'patient_id' => [
                'description' => 'ID of patient',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'patient_gbv_id' => [
                'description' => 'ID of patient gbv',
                'example' => fake()->randomElement(PatientGbv::pluck('id')->toArray()),
            ],
            'neglect_id' => [
                'description' => 'ID of lib neglect',
                'example' => fake()->randomElement(LibGbvNeglects::pluck('id')->toArray()),
            ],
        ];
    }
}
