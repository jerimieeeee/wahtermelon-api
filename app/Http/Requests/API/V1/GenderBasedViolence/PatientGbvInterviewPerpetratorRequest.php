<?php

namespace App\Http\Requests\API\V1\GenderBasedViolence;

use Illuminate\Foundation\Http\FormRequest;

class PatientGbvInterviewPerpetratorRequest extends FormRequest
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
            'patient_id' => 'required|exists:patients,id',
            'intake_id' => 'required|exists:patient_gbv_intakes,id',
            'perpetrator_unknown_flag' => 'nullable|boolean',
            'gender' => 'nullable',
            'perpetrator_name' => 'nullable',
            'perpetrator_nickname' => 'nullable',
            'perpetrator_age' => 'nullable|numeric',
            'known_to_child_flag' => 'nullable|boolean',
            'relation_to_child_id' => 'nullable|exists:lib_gbv_child_relations,id',
            'location_id' => 'nullable|exists:lib_gbv_perpetrator_locations,id',
            'perpetrator_address' => 'nullable',
            'abuse_alcohol_flag' => 'nullable|boolean',
            'abuse_drugs_flag' => 'nullable|boolean',
            'abuse_drugs_remarks' => 'nullable',
            'abuse_others_flag' => 'nullable|boolean',
            'abuse_others_remarks' => 'nullable',
            'abused_as_child_flag' => 'nullable|boolean',
            'abused_as_spouse_flag' => 'nullable|boolean',
            'spouse_abuser_flag' => 'nullable|boolean',
            'family_violence_flag' => 'nullable|boolean',
            'unknown_abused_flag' => 'nullable|boolean',
            'criminal_conviction_similar_flag' => 'nullable|boolean',
            'criminal_conviction_other_flag' => 'nullable|boolean',
            'criminal_record_unknown_flag' => 'nullable|boolean',
            'criminal_barangay_flag' => 'nullable|boolean',
            'criminal_barangay_remarks' => 'nullable',
            'occupation_code' => 'nullable|exists:lib_occupations,code',
        ];
    }
}
