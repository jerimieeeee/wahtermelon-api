<?php

namespace App\Http\Requests\API\V1\FamilyPlanning;

use Illuminate\Foundation\Http\FormRequest;

class PatientFpHistoryRequest extends FormRequest
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
            'history.*.history_code' => 'required|exists:lib_fp_histories,code',
        ];
    }
}
