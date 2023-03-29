<?php

namespace App\Http\Requests\API\V1\MaternalCare;

use Illuminate\Foundation\Http\FormRequest;

class PatientMcRequest extends FormRequest
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
            //'facility_code' => 'exists:facilities,code',
            'patient_id' => 'required|exists:patients,id',
            //'user_id' => 'required|exists:users,id',
            'pre_registration_date' => 'date|date_format:Y-m-d H:i:s|before:tomorrow|required_with:lmp_date',
            'lmp_date' => 'date|date_format:Y-m-d|before:tomorrow|required_with:pre_registration_date',
            'post_registration_date' => 'date|date_format:Y-m-d|before:tomorrow|required_with:delivery_date,admission_date,discharge_date,delivery_location_code',
            'delivery_date' => 'date|date_format:Y-m-d H:i:s|before:tomorrow|required_with:post_registration_date',
            'admission_date' => 'date|date_format:Y-m-d H:i:s|before:tomorrow|required_with:post_registration_date',
            'discharge_date' => 'date|date_format:Y-m-d H:i:s|before:tomorrow|required_with:post_registration_date',
            'delivery_location_code' => 'exists:lib_mc_delivery_locations,code|required_with:post_registration_date',
            'barangay_code' => 'exists:barangays,code|required_with:delivery_location_code',
        ];
    }
}
