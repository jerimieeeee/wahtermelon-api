<?php

namespace App\Http\Requests\API\V1\Laboratory;

use Illuminate\Foundation\Http\FormRequest;

class ConsultLaboratoryHematologyRequest extends FormRequest
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
            'hemoglobin' => 'nullable',
            'referral_facility' => 'nullable',
            'hematocrit' => 'nullable',
            'rbc' => 'nullable',
            'mcv' => 'nullable',
            'mch' => 'nullable',
            'mchc' => 'nullable',
            'wbc' => 'nullable',
            'neutrophils' => 'nullable',
            'lymphocytes' => 'nullable',
            'basophils' => 'nullable',
            'monocytes' => 'nullable',
            'eosinophils' => 'nullable',
            'stab' => 'nullable',
            'juvenile' => 'nullable',
            'platelets' => 'nullable',
            'reticulocytes' => 'nullable',
            'bleeding_time' => 'nullable',
            'clothing_time' => 'nullable',
            'esr' => 'nullable',
            'blood_type_code' => 'sometimes|exists:lib_blood_types,code',
            'remarks' => 'nullable',
            'lab_status_code' => 'required|exists:lib_laboratory_statuses,code',
        ];
    }
}
