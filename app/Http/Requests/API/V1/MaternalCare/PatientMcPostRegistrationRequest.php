<?php

namespace App\Http\Requests\API\V1\MaternalCare;

use App\Models\V1\Patient\Patient;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class PatientMcPostRegistrationRequest extends FormRequest
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
    public function validatedWithCasts(): array
    {
        $patient = Patient::find(request()->patient_id);
        $age = $patient->birthdate->diff(request()->post_registration_date)->y;
        return array_merge($this->validated(), [
            'patient_age' => $age,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'facility_code' => 'exists:facilities,code',
            'patient_id' => 'required|exists:patients,id',
            'user_id' => 'required|exists:users,id',
            'post_registration_date' => 'date|date_format:Y-m-d|before:tomorrow|required',
            'admission_date' => 'date|date_format:Y-m-d H:i:s|before:tomorrow|required',
            'discharge_date' => 'date|date_format:Y-m-d H:i:s|before:tomorrow|required',
            'delivery_date' => 'date|date_format:Y-m-d H:i:s|before:tomorrow|required',
            'delivery_location_code' => 'required|exists:lib_mc_delivery_locations,code',
            'barangay_code' => 'required|exists:barangays,code',
            'gravidity' => 'required|numeric',
            'parity' => 'required|numeric',
            'full_term' => 'required|numeric',
            'preterm' => 'required|numeric',
            'abortion' => 'required|numeric',
            'livebirths' => 'required|numeric',
            'outcome_code' => 'required|exists:lib_mc_outcomes,code',
            'healthy_baby' => 'required|boolean',
            'birth_weight' => 'required|numeric',
            'attendant_code' => 'required|exists:lib_mc_attendants,code',
            'breastfeeding' => 'required|boolean',
            'breastfed_date' => 'required_if:breastfeeding,true|date|date_format:Y-m-d|before:tomorrow',
            'end_pregnancy' => 'boolean',
            'postpartum_remarks' => 'string|nullable'
        ];
    }
}
