<?php

namespace App\Http\Requests\API\V1\Household;

use Illuminate\Foundation\Http\FormRequest;

class HouseholdEnvironmentalRequest extends FormRequest
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
            'household_folder_id' => 'required|exists:household_folders,id',
            'number_of_families' => 'required|numeric',
            'registration_date' => 'required|date|date_format:Y-m-d|before:tomorrow',
            'effectivity_year' => 'required',
            'water_type_code' => 'required|exists:lib_environmental_water_types,code',
            'safety_managed_flag' => 'required|boolean',
            'sanitation_managed_flag' => 'required|boolean',
            'satisfaction_management_flag' => 'required|boolean',
            'complete_sanitation_flag' => 'required|boolean',
            'located_premises_flag' => 'required|boolean',
            'availability_flag' => 'required|boolean',
            'microbiological_result' => 'nullable|exists:lib_environmental_results,code',
            'validation_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'arsenic_result' => 'nullable|exists:lib_environmental_results,code',
            'arsenic_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'open_defecation_flag' => 'required|boolean',
            'toilet_facility_code' => 'required|exists:lib_environmental_toilet_facilities,code',
            'toilet_shared_flag' => 'required|boolean',
            'sewage_code' => 'required|exists:lib_environmental_sewages,code',
            'waste_management_code' => 'required|exists:lib_environmental_waste_management,code',
            'remarks' => 'nullable',
            'end_sanitation_flag' => 'required|boolean',
        ];
    }
}
