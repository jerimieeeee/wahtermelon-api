<?php

namespace App\Http\Requests\API\V1\NCD;

use Illuminate\Foundation\Http\FormRequest;

class ConsultNcdRiskCasdt2Request extends FormRequest
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
            'consult_ncd_risk_id' => 'required|exists:consult_ncd_risk_assessment,id',
            'patient_ncd_id' => 'required|exists:patient_ncd,id',
            'consult_id' => 'required|exists:consults,id',
            'patient_id' => 'required|exists:patients,id',

            'complaint.*.eye_complaint' => 'nullable|exists:lib_ncd_eye_complaints,code',
            'eye_refer' => 'nullable|exists:lib_ncd_eye_refers,code',
            'unaided' => 'nullable|exists:lib_ncd_eye_vision_screenings,code',
            'pinhole' => 'nullable|exists:lib_ncd_eye_vision_screenings,code',
            'improved' => 'nullable|exists:lib_ncd_eye_vision_screenings,code',
            'aided' => 'nullable|exists:lib_ncd_eye_vision_screenings,code',
            'eye_refer_prof' => 'nullable|exists:lib_ncd_eye_refer_professionals,code',
        ];
    }
}
