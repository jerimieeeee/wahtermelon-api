<?php

namespace App\Http\Requests\API\V1\Eclaims;

use Illuminate\Foundation\Http\FormRequest;

class EclaimsXmlRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'program_desc' => 'required',
            'program_id' => 'required',
            'admit_dx' => 'required',
            'caserate_date' => 'required',
            'caserate_code' => 'required',
            'code' => 'required',
            'description' => 'required',
            'hci_fee' => 'required',
            'prof_fee' => 'required',
            'caserate_fee' => 'required',
            'admission_date' => 'required',
            'admission_time' => 'required',
            'discharge_date' => 'required',
            'discharge_time' => 'required',
            'attendant_accreditation_code' => 'required',
            'attendant_last_name' => 'required',
            'attendant_first_name' => 'required',
            'attendant_middle_name' => 'required',
            'attendant_suffix_name' => 'required',
            'attendant_sign_date' => 'required'
        ];
    }
}
