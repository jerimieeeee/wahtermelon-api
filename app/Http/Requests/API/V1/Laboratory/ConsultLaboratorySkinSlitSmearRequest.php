<?php

namespace App\Http\Requests\API\V1\Laboratory;

use Illuminate\Foundation\Http\FormRequest;

class ConsultLaboratorySkinSlitSmearRequest extends FormRequest
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

            'site_slit1' => 'nullable',
            'site_slit2' => 'nullable',
            'site_slit3' => 'nullable',
            'site_slit4' => 'nullable',
            'site_slit5' => 'nullable',
            'site_slit6' => 'nullable',

            'bac_index1' => 'nullable',
            'bac_index2' => 'nullable',
            'bac_index3' => 'nullable',
            'bac_index4' => 'nullable',
            'bac_index5' => 'nullable',
            'bac_index6' => 'nullable',

            'morp_index1' => 'nullable',
            'morp_index2' => 'nullable',
            'morp_index3' => 'nullable',
            'morp_index4' => 'nullable',
            'morp_index5' => 'nullable',
            'morp_index6' => 'nullable',

            'comment1' => 'nullable',
            'comment2' => 'nullable',
            'comment3' => 'nullable',
            'comment4' => 'nullable',
            'comment5' => 'nullable',
            'comment6' => 'nullable',

            'avg_bac_index' => 'nullable',
            'avg_morp_index' => 'nullable',

            'final_comment' => 'nullable',

            'remarks' => 'nullable',
            'lab_status_code' => 'required|exists:lib_laboratory_statuses,code',
        ];
    }
}
