<?php

namespace App\Http\Requests\API\V1\MaternalCare;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class PatientMcPreRegistrationRequest extends FormRequest
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

    public function prepareForValidation(): void
    {
        $lmp = new Carbon(request()->lmp_date);
        $this->merge([
            'edc_date' =>  $lmp->clone()->addDays(280)->format('Y-m-d'),
            'trimester1_date' => $lmp->clone()->addDays(84)->format('Y-m-d'),
            'trimester2_date' => $lmp->clone()->addDays(189)->format('Y-m-d'),
            'trimester3_date' => $lmp->clone()->addDays(280)->format('Y-m-d'),
            'postpartum_date' => $lmp->clone()->addDays(322)->format('Y-m-d'),
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
            'pre_registration_date' => 'date|date_format:Y-m-d|before:tomorrow|required',
            'lmp_date' => 'date|date_format:Y-m-d|before:tomorrow|required',
        ];
    }
}
