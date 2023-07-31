<?php

namespace App\Http\Requests\API\V1\FamilyPlanning;

use Illuminate\Foundation\Http\FormRequest;

class PatientFpPhysicalExamRequest extends FormRequest
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
            'physical_exam.*.pe_id' => 'required|exists:lib_pes,pe_id',
        ];
    }
}
