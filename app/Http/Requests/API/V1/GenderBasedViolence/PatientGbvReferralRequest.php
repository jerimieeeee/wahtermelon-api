<?php

namespace App\Http\Requests\API\V1\GenderBasedViolence;

use App\Models\V1\GenderBasedViolence\PatientGbv;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Foundation\Http\FormRequest;

class PatientGbvReferralRequest extends FormRequest
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
            'patient_gbv_id' => 'required|exists:patient_gbvs,id',
            'referral_facility_code' => 'nullable|exists:facilities,code',
            'referral_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'referral_reason' => 'nullable',
            'service_remarks' => 'nullable',
            'referral_remarks' => 'nullable',
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
            'referral_facility_code' => [
                'description' => 'ID of lib gbv behavioral',
                'example' => fake()->randomElement(Facility::pluck('code')->toArray()),
            ],
            'referral_reason' => [
                'description' => 'Referral remarks',
                'example' => fake()->sentence(),
            ],
            'service_remarks' => [
                'description' => 'Referral remarks',
                'example' => fake()->sentence(),
            ],
        ];
    }
}
