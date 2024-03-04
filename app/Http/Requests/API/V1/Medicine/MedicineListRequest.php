<?php

namespace App\Http\Requests\API\V1\Medicine;

use Illuminate\Foundation\Http\FormRequest;

class MedicineListRequest extends FormRequest
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
            'brand_name' => 'nullable',
            'medicine_code' => 'nullable|exists:lib_medicines,hprodid',
            'konsulta_medicine_code' => 'nullable|exists:lib_konsulta_medicines,code',
            'added_medicine' => 'nullable',
            'dosage_quantity' => 'required:numeric',
            'dosage_uom' => 'required:exists:lib_medicine_unit_of_measurements,code',
            'dose_regimen' => 'required:exists:lib_medicine_dose_regimens,code',
            'medicine_purpose' => 'required:exists:lib_medicine_purposes,code',
            'purpose_other' => 'nullable',
            'duration_intake' => 'required:numeric',
            'duration_frequency' => 'required:exists:lib_medicine_duration_frequencies,code',
            'quantity' => 'numeric',
            'quantity_preparation' => 'required:exists:lib_medicine_preparations,code',
            'medicine_route' => 'required:exists:lib_medicine_routes,code'
        ];
    }
}
