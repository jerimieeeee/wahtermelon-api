<?php

namespace App\Http\Requests\API\V1\NCD;

use Illuminate\Foundation\Http\FormRequest;

class ConsultNcdRiskCasdt2VisionRequest extends FormRequest
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
            'casdt2_id' => 'required|exists:consult_ncd_risk_casdt2s,id',
            'patient_id' => 'required|exists:patients,id',
            'eye_complaint' => 'nullable|exists:lib_ncd_eye_complaints,code',
        ];
    }
}
