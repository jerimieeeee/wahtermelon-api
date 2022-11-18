<?php

namespace App\Http\Requests\API\V1\MaternalCare;

use App\Models\User;
use App\Models\V1\Libraries\LibMcRiskFactor;
use App\Models\V1\MaternalCare\PatientMc;
use App\Models\V1\MaternalCare\PatientMcPreRegistration;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Foundation\Http\FormRequest;

class ConsultMcRiskRequest extends FormRequest
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
            'patient_mc_id' => 'required|exists:patient_mc_pre_registrations,patient_mc_id',
            'facility_code' => 'exists:facilities,code',
            'patient_id' => 'required|exists:patients,id',
            'user_id' => 'required|exists:users,id',
            'risk_id' => 'required|exists:lib_mc_risk_factors,id',
            'date_detected' => 'date|date_format:Y-m-d|before:tomorrow|nullable',
        ];
    }

    public function bodyParameters()
    {
        $mcId = PatientMc::whereHas('preRegister')->inRandomOrder()->limit(1)->first();
        return [
            'patient_mc_id' => [
                'description' => 'ID of maternal care record',
                'example' => $mcId->id,
            ],
            'facility_code' => [
                'description' => 'ID of facility library',
                'example' => fake()->randomElement(Facility::pluck('code')->toArray()),
            ],
            'patient_id' => [
                'description' => 'ID of patient',
                'example' => $mcId->patient_id,
            ],
            'user_id' => [
                'description' => 'ID of user',
                'example' => fake()->randomElement(User::pluck('id')->toArray()),
            ],
            'risk_id' => [
                'description' => 'ID of risk factor',
                'example' => fake()->randomElement(LibMcRiskFactor::pluck('id')->toArray()),
            ],
            'date_detected' => [
                'description' => 'Detected date of risk factor',
                'example' => fake()->dateTimeInInterval('-'. fake()->numberBetween(1,7) .' week')->format('Y-m-d'),
            ]
        ];
    }
}
