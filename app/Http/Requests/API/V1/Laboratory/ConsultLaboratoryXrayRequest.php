<?php

namespace App\Http\Requests\API\V1\Laboratory;

use Illuminate\Foundation\Http\FormRequest;

class ConsultLaboratoryXrayRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
            'xray_type' => 'required|exists:lib_laboratory_malaria_rdt_parasite_types,code',
            'result' => 'nullable',
            'remarks' => 'nullable',
            'lab_status_code' => 'required|exists:lib_laboratory_statuses,code',
        ];
    }
}
