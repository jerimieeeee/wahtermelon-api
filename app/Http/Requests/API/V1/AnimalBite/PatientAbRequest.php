<?php

namespace App\Http\Requests\API\V1\AnimalBite;

use Illuminate\Foundation\Http\FormRequest;

class PatientAbRequest extends FormRequest
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
            'consult_date' => 'required|date|date_format:Y-m-d|before:tomorrow',
            'exposure_date' => 'required|date|date_format:Y-m-d|before:tomorrow',
            'ab_treatment_outcome_id' => 'nullable|exists:lib_ab_outcomes,id',
            'date_outcome' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'manifestations' => 'nullable',
            'date_onset' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'date_died' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'death_remarks' => 'nullable',

            'animal_type_id' => 'required|exists:lib_ab_animal_types,id',
            'animal_ownership_id' => 'required|exists:lib_ab_animal_ownerships,id',
            'animal_vaccine_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'category_id' => 'required|exists:lib_ab_categories,id',
            'exposure_type_code' => 'required|exists:lib_ab_exposure_types,code',

            'animal_type_remarks' => 'nullable',
            'exposure_place' => 'nullable',
            'bite_flag' => 'nullable|boolean',

            'feet_flag' => 'nullable|boolean',
            'leg_flag' => 'nullable|boolean',
            'arms_flag' => 'nullable|boolean',
            'hand_flag' => 'nullable|boolean',
            'knee_flag' => 'nullable|boolean',
            'neck_flag' => 'nullable|boolean',
            'head_flag' => 'nullable|boolean',
            'others_flag' => 'nullable|boolean',
            'al_remarks' => 'nullable',

            'wash_flag' => 'nullable|boolean',
            'pep_flag' => 'nullable|boolean',
            'tandok_name' => 'nullable',
            'tandok_addresss' => 'nullable',
            'tandok_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
        ];
    }
}
