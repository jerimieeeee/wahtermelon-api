<?php

namespace App\Http\Requests\API\V1\FamilyPlanning;

use Illuminate\Foundation\Http\FormRequest;

class PatientFpRequest extends FormRequest
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
            'no_of_living_children_desired' => 'required|numeric',
            'no_of_living_children_actual' => 'required|numeric',
            'birth_interval_desired' => 'required|numeric',
            'average_monthly_income' => 'required|numeric',
//            'pe_remarks' => 'nullable',
        ];
    }
}
