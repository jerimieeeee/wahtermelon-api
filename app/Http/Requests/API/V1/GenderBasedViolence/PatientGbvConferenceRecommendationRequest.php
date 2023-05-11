<?php

namespace App\Http\Requests\API\V1\GenderBasedViolence;

use Illuminate\Foundation\Http\FormRequest;

class PatientGbvConferenceRecommendationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'conference_id' => 'required|exists:patient_gbv_conferences,id',
            'recommend_code' => 'nullable|exists:lib_gbv_conference_recommendations,id',
            'recommendation_remarks' => 'nullable',
            'recommendation_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
        ];
    }
}
