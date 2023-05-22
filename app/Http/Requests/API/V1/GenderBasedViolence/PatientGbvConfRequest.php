<?php

namespace App\Http\Requests\API\V1\GenderBasedViolence;

use Illuminate\Foundation\Http\FormRequest;

class PatientGbvConfRequest extends FormRequest
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
            'id' => 'nullable',
            'patient_id' => 'required|exists:patients,id',
            'patient_gbv_id' => 'required|exists:patient_gbvs,id',

            'conference_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'notes' => 'nullable',
            'conference_invitee_remarks' => 'nullable',
            'conference_concern_remarks' => 'nullable',
            'conference_mitigating_factor_remarks' => 'nullable',
            'conference_recommendation_remarks' => 'nullable',

            'invites' => 'nullable|array',
            'invites.*.invite_code' => 'nullable|exists:lib_gbv_conference_invitees,id',

            'concerns' => 'nullable|array',
            'concerns.*.concern_code' => 'nullable|exists:lib_gbv_conference_concerns,id',

            'mitigations' => 'nullable|array',
            'mitigations.*.factor_code' => 'nullable|exists:lib_gbv_conference_mitigating_factors,id',

            'recommendations' => 'nullable|array',
            'recommendations.*.recommend_code' => 'nullable|exists:lib_gbv_conference_recommendations,id',
        ];
    }
}
