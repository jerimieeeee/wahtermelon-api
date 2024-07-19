<?php

namespace App\Http\Requests\API\V1\TBDots;

use Illuminate\Foundation\Http\FormRequest;

class PatientTbDotsChartRequest extends FormRequest
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
            'patient_tb_id' => 'exists:patient_tbs,id',
            'dots.*.dots_date' => 'required|date',
            'dots.*.dots_type' => 'required',
        ];
    }
}
