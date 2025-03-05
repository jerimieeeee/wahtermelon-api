<?php

namespace App\Http\Requests\API\V1\Adolescent;

use Illuminate\Foundation\Http\FormRequest;

class ConsultAsrhComprehensiveRequest extends FormRequest
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
            'patient_id' => ['required', 'exists:patients,id'],
            'consult_asrh_rapid_id' => ['required', 'exists:consult_asrh_rapids,id'],
            'assessment_date' => ['required', 'date', 'date_format:Y-m-d'],
            'consent_flag' => ['nullable', 'boolean'],
            'lib_asrh_consent_type_id' => ['required_if:consent_flag,1', 'exists:lib_asrh_consent_types,id'],
            'consent_type_other' => ['required_if:lib_asrh_consent_type_id,99', 'string'],
            'home_notes' => ['required_if:done_flag,1', 'string', 'min:50'],
            'education_notes' => ['required_if:done_flag,1', 'string', 'min:50'],
            'eating_notes' => ['required_if:done_flag,1', 'string', 'min:50'],
            'activities_notes' => ['required_if:done_flag,1', 'string', 'min:50'],
            'drugs_notes' => ['required_if:done_flag,1', 'string', 'min:50'],
            'sexuality_notes' => ['required_if:done_flag,1', 'string', 'min:50'],
            'suicide_notes' => ['required_if:done_flag,1', 'string', 'min:50'],
            'safety_notes' => ['required_if:done_flag,1', 'string', 'min:50'],
            'spirituality_notes' => ['required_if:done_flag,1', 'string', 'min:50'],
            'risky_behavior' => ['nullable', 'boolean'],
            'self_harm' => ['nullable', 'boolean'],
            'seriously_injured' => ['nullable', 'boolean'],
            'refused_flag' => ['nullable', 'boolean'],
            'lib_asrh_refusal_reason_id' => ['required_if:refused_flag,1', 'exists:lib_asrh_refusal_reasons,id'],
            'refusal_reason_other' => ['required_if:lib_asrh_refusal_reason_id,99', 'string'],
            'done_flag' => ['nullable', 'boolean'],
            'done_date' => ['required_if:done_flag,1', 'date', 'date_format:Y-m-d'],
            'referral_date' => ['nullable', 'date', 'date_format:Y-m-d'],
        ];
    }
}
