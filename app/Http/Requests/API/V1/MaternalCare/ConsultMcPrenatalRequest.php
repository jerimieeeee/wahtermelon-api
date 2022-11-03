<?php

namespace App\Http\Requests\API\V1\MaternalCare;

use Illuminate\Foundation\Http\FormRequest;

class ConsultMcPrenatalRequest extends FormRequest
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
            'patient_mc_id' => 'required|exists:patient_mc,id',
            'facility_code' => 'exists:facilities,code',
            'patient_id' => 'required|exists:patients,id',
            'user_id' => 'required|exists:users,id',
            'prenatal_date' => 'date|date_format:Y-m-d|before:tomorrow|required',
            'patient_height' => 'required|numeric',
            'patient_weight' => 'required|numeric',
            'bp_systolic' => 'required|numeric',
            'bp_diastolic' => 'required|numeric',
            'fundic_height' => 'numeric',
            'presentation_code' => 'required|exists:lib_mc_presentations,code',
            'fhr' => 'numeric',
            'location_code' => 'required|exists:lib_mc_locations,code',
            'private' => 'boolean'
        ];
    }
}
