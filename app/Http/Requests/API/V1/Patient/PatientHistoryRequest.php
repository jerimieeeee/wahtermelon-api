<?php

namespace App\Http\Requests\API\V1\Patient;

use App\Models\V1\Libraries\LibMedicalHistory;
use App\Models\V1\Libraries\LibMedicalHistoryCategory;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Http\FormRequest;

class PatientHistoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'medical_history.*.medical_history_id' => 'required|exists:lib_medical_histories,id',
            'medical_history.*.category' => 'required|exists:lib_medical_history_categories,id',
            'medical_history.*.remarks' => 'nullable',
        ];
    }

    public function bodyParameters()
    {
        return [
            'patient_id' => [
                'description' => 'ID of patient.',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'medical_history_id' => [
                'description' => 'ID of medical history',
                'example' => fake()->randomElement(LibMedicalHistory::pluck('id')->toArray()),
            ],
            'category' => [
                'description' => 'ID of medical history category',
                'example' => fake()->randomElement(LibMedicalHistoryCategory::pluck('id')->toArray()),
            ],
            'remarks' => [
                'description' => 'remarks of patient history',
                'example' => fake()->sentence(),
            ],
        ];
    }
}
