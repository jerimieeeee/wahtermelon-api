<?php

namespace App\Http\Requests\API\V1\GenderBasedViolence;

use Illuminate\Foundation\Http\FormRequest;

class PatientGbvPlacementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
            'patient_gbv_intake_id' => 'required|exists:patient_gbv_intakes,id',
            'location_id' => 'nullable|exists:lib_gbv_placement_locations,id',
            'home_by_cpu_flag' => 'nullable|boolean',
            'home_by_other_name' => 'nullable',
            'scheduled_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'actual_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'placement_name' => 'nullable',
            'placement_contact_info' => 'nullable|min:11|max:13',
            'type_id' => 'nullable|exists:lib_gbv_placement_types,id',
            'hospital_name' => 'nullable',
            'hospital_ward' => 'nullable',
            'hospital_date_in' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'hospital_date_out' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
        ];
    }
}
