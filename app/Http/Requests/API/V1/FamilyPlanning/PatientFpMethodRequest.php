<?php

namespace App\Http\Requests\API\V1\FamilyPlanning;

use Illuminate\Foundation\Http\FormRequest;

class PatientFpMethodRequest extends FormRequest
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
            'patient_fp_id' => 'required|exists:patient_fp,id',
            'method_code' => 'required|exists:lib_fp_methods,code',
            'enrollment_date' => 'required|date|date_format:Y-m-d|before:tomorrow',
            'client_code' => 'required|exists:lib_fp_client_types,code',
            'treatment_partner' => 'required',
            'permananent_reason' => 'nullable',
            'dropout_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'dropout_reason_code' => 'nullable|exists:lib_fp_dropout_reasons,code',
            'dropout_remarks' => 'nullable',
        ];
    }
}
