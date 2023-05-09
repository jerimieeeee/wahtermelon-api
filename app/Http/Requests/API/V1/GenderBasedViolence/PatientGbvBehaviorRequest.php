<?php

namespace App\Http\Requests\API\V1\GenderBasedViolence;

use App\Models\V1\GenderBasedViolence\PatientGbv;
use App\Models\V1\Libraries\LibComplaint;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Http\FormRequest;

class PatientGbvBehaviorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'patient_gbv_id' => 'required|exists:patient_gbvs,id',
            'behavioral_id' => 'nullable|exists:lib_gbv_behaviorals,id',
        ];
    }

    public function bodyParameters()
    {
        return [
            'patient_id' => [
                'description' => 'ID of patient',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'patient_gbv_id' => [
                'description' => 'ID of patient gbv',
                'example' => fake()->randomElement(PatientGbv::pluck('id')->toArray()),
            ],
            'behavioral_id' => [
                'description' => 'ID of lib gbv behavioral',
                'example' => fake()->randomElement(LibComplaint::pluck('id')->toArray()),
            ],
        ];
    }
}
