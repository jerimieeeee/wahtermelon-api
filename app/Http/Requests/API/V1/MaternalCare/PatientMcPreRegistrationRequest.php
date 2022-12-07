<?php

namespace App\Http\Requests\API\V1\MaternalCare;

use App\Models\V1\Patient\Patient;
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function validatedWithCasts(): array
    {
        $lmp = new Carbon(request()->lmp_date);
        $patient = Patient::find(request()->patient_id);
        $age = $patient->birthdate->diff(request()->pre_registration_date)->y;
        return array_merge($this->validated(), [
            'patient_age' => $age,
            'edc_date' =>  $lmp->clone()->addDays(280)->format('Y-m-d'),
            'trimester1_date' => $lmp->clone()->addDays(84)->format('Y-m-d'),
            'trimester2_date' => $lmp->clone()->addDays(189)->format('Y-m-d'),
            'trimester3_date' => $lmp->clone()->addDays(280)->format('Y-m-d'),
            'postpartum_date' => $lmp->clone()->addDays(322)->format('Y-m-d'),
        ]);
        /*$this->merge([
            'edc_date' =>  $lmp->clone()->addDays(280)->format('Y-m-d'),
            'trimester1_date' => $lmp->clone()->addDays(84)->format('Y-m-d'),
            'trimester2_date' => $lmp->clone()->addDays(189)->format('Y-m-d'),
            'trimester3_date' => $lmp->clone()->addDays(280)->format('Y-m-d'),
            'postpartum_date' => $lmp->clone()->addDays(322)->format('Y-m-d'),
        ]);*/
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
            'pre_registration_date' => 'date|date_format:Y-m-d|before:tomorrow|required',
            'lmp_date' => 'date|date_format:Y-m-d|before:tomorrow|required',
            'initial_gravidity' => 'required|numeric',
            'initial_parity' => 'required|numeric',
            'initial_full_term' => 'required|numeric',
            'initial_preterm' => 'required|numeric',
            'initial_abortion' => 'required|numeric',
            'initial_livebirths' => 'required|numeric',
        ];
    }
}
