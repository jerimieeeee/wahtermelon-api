<?php

namespace App\Http\Requests\API\V1\Laboratory;

use Illuminate\Foundation\Http\FormRequest;

class ConsultLaboratoryBloodChemistryRequest extends FormRequest
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

            'bicarbonate' => 'nullable',
            'calcium' => 'nullable',
            'chloride' => 'nullable',
            'magnesium' => 'nullable',
            'phosphorus' => 'nullable',
            'potassium' => 'nullable',
            'sodium' => 'nullable',

            'alkaline_phosphatase' => 'nullable',
            'amylase' => 'nullable',
            'creatine_kinase' => 'nullable',
            'lipase' => 'nullable',
            'alt' => 'nullable',
            'ast' => 'nullable',

            'albumin' => 'nullable',
            'total_bilirubin' => 'nullable',
            'direct_bilirubin' => 'nullable',
            'cholesterol' => 'nullable',
            'creatinine' => 'nullable',
            'globulin' => 'nullable',
            'glucose' => 'nullable',
            'protein' => 'nullable',
            'triglycerides' => 'nullable',
            'urea' => 'nullable',
            'uric_acid' => 'nullable',
            'fbs' => 'nullable',
            'rbs' => 'nullable',

            'remarks' => 'nullable',
            'lab_status_code' => 'required|exists:lib_laboratory_statuses,code',
        ];
    }
}
