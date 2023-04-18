<?php

namespace App\Http\Requests\API\V1\TBDots;

use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Http\FormRequest;

class PatientTbSymptomRequest extends FormRequest
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
            'patient_tb_id' => 'required|exists:patient_tbs,id',
            'bcpain' => 'boolean',
            'cough' => 'boolean',
            'drest' => 'boolean',
            'dexertion' => 'boolean',
            'fever' => 'boolean',
            'hemoptysis' => 'boolean',
            'nsweats' => 'boolean',
            'pedema' => 'boolean',
            'wloss' => 'boolean',
            'symptoms_remarks' => 'nullable',
        ];
    }

    public function bodyParameters()
    {
        return [
            'patient_id' => [
                'description' => 'ID of patient',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'bcpain' => [
                'description' => 'Value of backpain symptom',
                'example' => fake()->boolean(),
            ],
            'cough' => [
                'description' => 'Value of cough symptom',
                'example' => fake()->boolean(),
            ],
            'drest' => [
                'description' => 'Value of Dyspnea at rest symptom',
                'example' => fake()->boolean(),
            ],
            'dexertion' => [
                'description' => 'Value of Dyspnea on exertion symptom',
                'example' => fake()->boolean(),
            ],
            'fever' => [
                'description' => 'Value of Fever symptom',
                'example' => fake()->boolean(),
            ],
            'hemoptysis' => [
                'description' => 'Value of Hemoptysis symptom',
                'example' => fake()->boolean(),
            ],
            'nsweats' => [
                'description' => 'Value of Night sweats symptom',
                'example' => fake()->boolean(),
            ],
            'pedema' => [
                'description' => 'Value of Pedema symptom',
                'example' => fake()->boolean(),
            ],
            'wloss' => [
                'description' => 'Value of Weight losssymptom',
                'example' => fake()->boolean(),
            ],
            'symptoms_remarks' => [
                'description' => 'Remarks for TB Symptoms',
                'example' => fake()->sentence(),
            ],
        ];
    }
}
