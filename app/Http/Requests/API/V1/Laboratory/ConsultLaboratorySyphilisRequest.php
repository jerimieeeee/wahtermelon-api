<?php

namespace App\Http\Requests\API\V1\Laboratory;

use Illuminate\Foundation\Http\FormRequest;

class ConsultLaboratorySyphilisRequest extends FormRequest
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
            'consult_id' => 'nullable|exists:consults,id',
            'request_id' => 'required|exists:consult_laboratories,id',
            'laboratory_date' => 'date|date_format:Y-m-d|before:tomorrow|required',
            'referral_facility' => 'nullable',
            'method_code' => 'required|exists:lib_laboratory_syphilis_test_methods,code',
            'other_method' => 'nullable',
            'findings_code' => 'required|exists:lib_laboratory_results,code',
            'remarks' => 'nullable',
            'lab_status_code' => 'required|exists:lib_laboratory_statuses,code',
        ];
    }
}
