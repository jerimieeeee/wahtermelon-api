<?php

namespace App\Http\Requests\API\V1\MaternalCare;

use App\Models\V1\MaternalCare\PatientMcPostRegistration;
use Illuminate\Foundation\Http\FormRequest;

class ConsultMcPostpartumRequest extends FormRequest
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
        $mc = PatientMcPostRegistration::select('delivery_date')->where('patient_mc_id', request()->patient_mc_id)->first();

        $weeks = get_postpartum_week(request()->postpartum_date, $mc->delivery_date);
        return array_merge($this->validated(), [
            'postpartum_week' => $weeks,
            'visit_sequence' => 0,
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
            'patient_mc_id' => 'required|exists:patient_mc,id',
            'facility_code' => 'exists:facilities,code',
            'patient_id' => 'required|exists:patients,id',
            'user_id' => 'required|exists:users,id',
            'postpartum_date' => 'date|date_format:Y-m-d|before:tomorrow|required',
            'visit_type' => 'required|exists:lib_mc_visit_types,code',
            'patient_height' => 'required|numeric',
            'patient_weight' => 'required|numeric',
            'bp_systolic' => 'required|numeric',
            'bp_diastolic' => 'required|numeric',
            'breastfeeding' => 'boolean',
            'family_planning' => 'boolean',
            'fever' => 'boolean',
            'vaginal_infection' => 'boolean',
            'vaginal_bleeding' => 'boolean',
            'pallor' => 'boolean',
            'cord_ok' => 'boolean',
        ];
    }
}
