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
            'home_notes' => ['required_if:done_flag,1', 'string'],
            'education_notes' => ['required_if:done_flag,1', 'string'],
            'eating_notes' => ['required_if:done_flag,1', 'string'],
            'activities_notes' => ['required_if:done_flag,1', 'string'],
            'drugs_notes' => ['required_if:done_flag,1', 'string'],
            'sexuality_notes' => ['required_if:done_flag,1', 'string'],
            'suicide_notes' => ['required_if:done_flag,1', 'string'],
            'safety_notes' => ['required_if:done_flag,1', 'string'],
            'spirituality_notes' => ['required_if:done_flag,1', 'string'],
            'risky_behavior' => ['nullable', 'boolean'],
            'seriously_injured' => ['nullable', 'boolean'],
            'refused_flag' => ['nullable', 'boolean'],
            'done_flag' => ['nullable', 'boolean'],
            'done_date' => ['required_if:done_flag,1', 'date', 'date_format:Y-m-d'],
            'referral_date' => ['nullable', 'date', 'date_format:Y-m-d'],
        ];
    }
}
