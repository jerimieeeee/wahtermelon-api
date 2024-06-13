<?php

namespace App\Http\Requests\API\V1\Consultation;

use Illuminate\Foundation\Http\FormRequest;

class ConsultFeedbackRequest extends FormRequest
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
            'consult_id' => 'required|exists:consults,id',
            'overall_score' => 'required|numeric',
            'cleanliness_score' => 'required|numeric',
            'behavior_score' => 'required|numeric',
            'time_score' => 'required|numeric',
            'quality_score' => 'required|numeric',
            'completeness_score' => 'required|numeric',
            'remarks' => 'nullable'
        ];
    }
}
