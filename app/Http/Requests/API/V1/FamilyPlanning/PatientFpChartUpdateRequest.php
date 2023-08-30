<?php

namespace App\Http\Requests\API\V1\FamilyPlanning;

use Illuminate\Foundation\Http\FormRequest;

class PatientFpChartUpdateRequest extends FormRequest
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
            'service_date' => 'required|date|date_format:Y-m-d|before:tomorrow',
            'source_supply_code' => 'required|exists:lib_fp_source_supplies,code',
            'next_service_date' => 'required|date|date_format:Y-m-d',
            'quantity' => 'nullable|numeric',
            'remarks' => 'nullable'
        ];
    }
}
