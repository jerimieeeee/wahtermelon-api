<?php

namespace App\Http\Requests\API\V1\Dental;

use Illuminate\Foundation\Http\FormRequest;

class DentalToothConditionRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'consult_id' => 'required|exists:consults,id',
            'tooth_arr.*.tooth_number' => 'required',
            'tooth_arr.*.tooth_condition' => 'required'
        ];
    }
}
