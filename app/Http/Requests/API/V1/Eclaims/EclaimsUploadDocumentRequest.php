<?php

namespace App\Http\Requests\API\V1\Eclaims;

use Illuminate\Foundation\Http\FormRequest;

class EclaimsUploadDocumentRequest extends FormRequest
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
            'doc' => 'required|mimes:pdf',
            'patient_id' => 'required|exists:patients,id',
            'pHospitalTransmittalNo' => 'required|exists:eclaims_uploads,pHospitalTransmittalNo',
            'doc_type_code' => 'required|exists:lib_eclaims_doc_types,code',
            'program_desc' => 'required',
        ];
    }
}
