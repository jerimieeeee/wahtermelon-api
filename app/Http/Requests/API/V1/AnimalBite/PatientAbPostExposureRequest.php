<?php

namespace App\Http\Requests\API\V1\AnimalBite;

use Illuminate\Foundation\Http\FormRequest;

class PatientAbPostExposureRequest extends FormRequest
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
            'patient_ab_id' => 'required|exists:patient_abs,id',
            'weight' => 'nullable|numeric',
            'animal_status_code' => 'required|exists:lib_ab_animal_statuses,code',
            'animal_status_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'rig_type_code' => 'required|exists:lib_ab_rig_types,code',
            'rig_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'booster_1_flag' => 'nullable|boolean',
            'booster_2_flag' => 'nullable|boolean',
            'other_vacc_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'other_vacc_desc' => 'nullable',
            'other_vacc_route_code' => 'nullable|exists:lib_ab_vaccine_routes,code',
            'day0_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'day0_vaccine_code' => 'nullable|exists:lib_ab_vaccines,code',
            'day0_vaccine_route_code' => 'nullable|exists:lib_ab_vaccine_routes,code',
            'day3_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'day3_vaccine_code' => 'nullable|exists:lib_ab_vaccines,code',
            'day3_vaccine_route_code' => 'nullable|exists:lib_ab_vaccine_routes,code',
            'day7_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'day7_vaccine_code' => 'nullable|exists:lib_ab_vaccines,code',
            'day7_vaccine_route_code' => 'nullable|exists:lib_ab_vaccine_routes,code',
            'day14_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'day14_vaccine_code' => 'nullable|exists:lib_ab_vaccines,code',
            'day14_vaccine_route_code' => 'nullable|exists:lib_ab_vaccine_routes,code',
            'day28_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'day28_vaccine_code' => 'nullable|exists:lib_ab_vaccines,code',
            'day28_vaccine_route_code' => 'nullable|exists:lib_ab_vaccine_routes,code',
        ];
    }
}
