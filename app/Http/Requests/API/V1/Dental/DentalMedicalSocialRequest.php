<?php

namespace App\Http\Requests\API\V1\Dental;

use Illuminate\Foundation\Http\FormRequest;

class DentalMedicalSocialRequest extends FormRequest
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
            'allergies_flag' => 'boolean|nullable',
            'hypertension_flag' => 'boolean|nullable',
            'diabetes_flag' => 'boolean|nullable',
            'blood_disorder_flag' => 'boolean|nullable',
            'heart_disease_flag' => 'boolean|nullable',
            'thyroid_flag' => 'boolean|nullable',
            'hepatitis_flag' => 'boolean|nullable',
            'malignancy_flag' => 'boolean|nullable',
            'blood_transfusion_flag' => 'boolean|nullable',
            'tattoo_flag' => 'boolean|nullable',
            'medical_others_flag' => 'boolean|nullable',
            'medical_remarks' => 'nullable',
            'sweet_flag' => 'boolean|nullable',
            'tabacco_flag' => 'boolean|nullable',
            'alcohol_flag' => 'boolean|nullable',
            'nut_flag' => 'boolean|nullable',
            'social_others_flag' => 'boolean|nullable',
            'social_remarks' => 'nullable'
        ];
    }
}
