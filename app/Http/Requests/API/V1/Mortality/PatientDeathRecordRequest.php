<?php

namespace App\Http\Requests\API\V1\Mortality;

use App\Models\V1\Patient\Patient;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class PatientDeathRecordRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function validatedWithCasts(): array
    {
        $patient = Patient::find(request()->patient_id);
        $age_years = Carbon::parse($patient->birthdate)->diff(request()->assessment_date)->y;
        $age_months = Carbon::parse($patient->birthdate)->diff(request()->assessment_date)->m;
        $age_days = Carbon::parse($patient->birthdate)->diff(request()->assessment_date)->d;

        return array_merge($this->validated(), [
            'age_years' => $age_years,
            'age_months' => $age_months,
            'age_days' => $age_days,
        ]);
    }

    public function rules(): array
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'date_of_death' => 'required|date|before:tomorrow',
            'death_type' => 'required|exists:lib_mortality_death_type,code',
            'death_place' => 'required|exists:lib_mortality_death_place,code',
            'barangay_code' => 'required|exists:barangays,psgc_10_digit_code',
            'immediate_cause' => 'nullable|exists:lib_icd10s,icd10_code',
            'cause.*.icd10_code' => 'nullable|exists:lib_icd10s,icd10_code',
            'cause.*.cause_code' => 'nullable|exists:lib_mortality_causes,code',
            'remarks' => 'nullable',
        ];
    }
}
