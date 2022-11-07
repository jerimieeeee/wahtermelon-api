<?php

namespace App\Http\Requests\API\V1\MaternalCare;

use App\Models\V1\MaternalCare\PatientMcPreRegistration;
use App\Models\V1\PSGC\Facility;
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

    public function validatedWithCasts()
    {
        if(!isset(request()->patient_mc_id)) {
            return;
        }
        $mc = PatientMcPreRegistration::select('id', 'lmp_date', 'trimester1_date', 'trimester2_date')->where('patient_mc_id', request()->patient_mc_id)->first();
        if($mc) {
            $numberOfDays = $mc->lmp_date->diff(request()->prenatal_date)->days;
            $weeks = floatval(($numberOfDays) / 7);
            $remainingDays = $numberOfDays % 7;
            if (request()->prenatal_date <= $mc->trimester1_date) {
                $trimester = 1;
            } else if (request()->prenatal_date > $mc->trimester1_date && request()->prenatal_date <= $mc->trimester2_date) {
                $trimester = 2;
            } else {
                $trimester = 3;
            }
            return $this->safe()->merge([
                'aog_weeks' => $weeks,
                'aog_days' => $remainingDays,
                'trimester' => $trimester,
                'visit_sequence' => 0,
            ]);
        }
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

    public function bodyParameters()
    {
        return [
            'facility_code' => [
                'description' => 'ID of facility library',
                'example' => fake()->randomElement(Facility::pluck('code')->toArray()),
            ],
        ];
    }
}
