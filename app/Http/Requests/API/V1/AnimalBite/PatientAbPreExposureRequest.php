<?php

namespace App\Http\Requests\API\V1\AnimalBite;

use Illuminate\Foundation\Http\FormRequest;

class PatientAbPreExposureRequest extends FormRequest
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
            'indication_option_code' => 'required|exists:lib_ab_indication_options,code',
            'indication_option_remarks' => 'nullable',
            'day0_date' => 'required|date|date_format:Y-m-d|before:tomorrow',
            'day0_vaccine_code' => 'required|exists:lib_ab_vaccines,code',
            'day0_vaccine_route_code' => 'required|exists:lib_ab_vaccine_routes,code',
            'day7_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'day7_vaccine_code' => 'nullable|exists:lib_ab_vaccines,code',
            'day7_vaccine_route_code' => 'nullable|exists:lib_ab_vaccine_routes,code',
            'day21_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'day21_vaccine_code' => 'nullable|exists:lib_ab_vaccines,code',
            'day21_vaccine_route_code' => 'nullable|exists:lib_ab_vaccine_routes,code',
            'remarks' => 'nullable',
        ];
    }
}
