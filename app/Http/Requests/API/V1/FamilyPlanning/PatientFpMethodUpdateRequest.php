<?php

namespace App\Http\Requests\API\V1\FamilyPlanning;

use Illuminate\Foundation\Http\FormRequest;

class PatientFpMethodUpdateRequest extends FormRequest
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
            'dropout_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'dropout_reason_code' => 'nullable|exists:lib_fp_dropout_reasons,code',
            'dropout_remarks' => 'nullable',
        ];
    }
}
