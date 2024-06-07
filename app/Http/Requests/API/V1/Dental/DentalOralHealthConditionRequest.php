<?php

namespace App\Http\Requests\API\V1\Dental;

use Illuminate\Foundation\Http\FormRequest;

class DentalOralHealthConditionRequest extends FormRequest
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
            'consult_id' => 'required|exists:consults,id',
            'healthy_gums_flag' => 'boolean|nullable',
            'orally_fit_flag' => 'boolean|nullable',
            'oral_rehab_flag' => 'boolean|nullable',
            'dental_caries_flag' => 'boolean|nullable',
            'gingivitis_flag' => 'boolean|nullable',
            'periodontal_flag' => 'boolean|nullable',
            'debris_flag' => 'boolean|nullable',
            'calculus_flag' => 'boolean|nullable',
            'abnormal_growth_flag' => 'boolean|nullable',
            'cleft_lip_flag' => 'boolean|nullable',
            'supernumerary_flag' => 'boolean|nullable',
            'dento_facial_flag' => 'nullable',
            'others_flag' => 'boolean|nullable',
            'remarks' => 'nullable'
        ];
    }
}
