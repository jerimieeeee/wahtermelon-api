<?php

namespace App\Http\Requests\API\V1\AnimalBite;

use Illuminate\Foundation\Http\FormRequest;

class PatientAbExposureRequest extends FormRequest
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
            'animal_type_id' => 'required|exists:lib_ab_animal_types,id',
            'animal_type_remarks' => 'nullable',
            'exposure_place' => 'nullable',
            'bite_flag' => 'nullable|boolean',
            'animal_ownership_id' => 'required|exists:lib_ab_animal_ownerships,id',
            'animal_vaccine_date' => 'nullable',
            'feet_flag' => 'nullable|boolean',
            'leg_flag' => 'nullable|boolean',
            'arms_flag' => 'nullable|boolean',
            'hand_flag' => 'nullable|boolean',
            'knee_flag' => 'nullable|boolean',
            'neck_flag' => 'nullable|boolean',
            'head_flag' => 'nullable|boolean',
            'others_flag' => 'nullable|boolean',
            'al_remarks' => 'nullable',
            'category_id' => 'required|exists:lib_ab_categories,id',
            'exposure_type_code' => 'required|exists:lib_ab_exposure_types,code',
            'wash_flag' => 'nullable|boolean',
            'pep_flag' => 'nullable|boolean',
            'tandok_name' => 'nullable',
            'tandok_date' => 'nullable',
            'tandok_addresss' => 'nullable',
            'remarks' => 'nullable',
            'consult_date' => 'required|date|date_format:Y-m-d|before:tomorrow',
            'exposure_date' => 'required|date|date_format:Y-m-d|before:tomorrow',
        ];
    }
}
