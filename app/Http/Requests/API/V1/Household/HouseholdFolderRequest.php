<?php

namespace App\Http\Requests\API\V1\Household;

use App\Models\V1\Libraries\LibFamilyRole;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Barangay;
use Illuminate\Foundation\Http\FormRequest;

class HouseholdFolderRequest extends FormRequest
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
    public function rules()
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'family_role_code' => 'required|exists:lib_family_roles,code',
            'address' => 'required',
            'barangay_code' => 'required|exists:barangays,code',
            'cct_date' => 'date|date_format:Y-m-d|before:tomorrow|nullable',
            'cct_id' => 'nullable'
        ];
    }

    public function bodyParameters()
    {
        return [
            'patient_id' => [
                'description' => 'ID of patient',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'family_role_code' => [
                'description' => 'Family role of the patient',
                'example' => fake()->randomElement(LibFamilyRole::pluck('code')->toArray())
            ],
            'address' => [
                'description' => 'Household address',
                'example' => fake()->address()
            ],
            'barangay_code' => [
                'description' => 'Household barangay code',
                'example' => fake()->randomElement(Barangay::pluck('code')->toArray())
            ],
            'cct_date' => [
                'description' => 'CCT Date of the household',
                'example' => fake()->optional()->date('Y-m-d')
            ],
            'cct_id' => [
                'description' => 'CCT Id of the household',
                'example' => fake()->optional()->randomDigit()
            ]
        ];
    }
}
