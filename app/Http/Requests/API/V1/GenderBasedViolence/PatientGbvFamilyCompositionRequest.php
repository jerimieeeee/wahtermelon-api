<?php

namespace App\Http\Requests\API\V1\GenderBasedViolence;

use App\Models\V1\GenderBasedViolence\PatientGbv;
use App\Models\V1\Libraries\LibEducation;
use App\Models\V1\Libraries\LibGbvChildRelation;
use App\Models\V1\Libraries\LibOccupation;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class PatientGbvFamilyCompositionRequest extends FormRequest
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
            'patient_gbv_id' => 'required|exists:patient_gbvs,id',
            'name' => 'nullable',
            'child_relation_id' => 'nullable|exists:lib_gbv_child_relations,id',
            'living_with_child_flag' => 'nullable|boolean',
            'age' => 'nullable|numeric',
            'gender' => 'nullable',
            'civil_status_code' => 'nullable|exists:lib_civil_statuses,code',
            'employed_flag' => 'nullable|boolean',
            'occupation_code' => 'nullable|exists:lib_occupations,code',
            'education_code' => 'nullable|exists:lib_education,code',
            'weekly_income' => 'nullable|numeric',
            'school' => 'nullable',
            'company' => 'nullable',
            'contact_information' => 'nullable|min:11|max:13',
        ];
    }

    public function bodyParameters()
    {
        $gender = fake()->randomElement(['male', 'female']);

        return [
            'patient_id' => [
                'description' => 'ID of patient',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'patient_gbv_id' => [
                'description' => 'ID of patient gbv',
                'example' => fake()->randomElement(PatientGbv::pluck('id')->toArray()),
            ],
            'name' => [
                'description' => 'name of gbv family compositions',
                'example' => fake()->name(),
            ],
            'child_relation_id' => [
                'description' => 'ID of patient gbv',
                'example' => fake()->randomElement(LibGbvChildRelation::pluck('id')->toArray()),
            ],
            'living_with_child_flag' => [
                'description' => 'Is living with child?',
                'example' => fake()->boolean(),
            ],
            'age' => [
                'description' => 'age of family composition',
                'example' => fake()->randomNumber(3, false),
            ],
            'gender' => [
                'description' => 'gender of family composition',
                'example' => substr(Str::ucfirst($gender), 0, 1),
            ],
            'civil_status_code' => [
                'description' => 'ID of patient gbv',
                'example' => fake()->randomElement(LibGbvChildRelation::pluck('id')->toArray()),
            ],
            'employed_flag' => [
                'description' => 'Is employed?',
                'example' => fake()->boolean(),
            ],
            'occupation_code' => [
                'description' => 'code of lib occupation',
                'example' => fake()->randomElement(LibOccupation::pluck('code')->toArray()),
            ],
            'education_code' => [
                'description' => 'code of lib education',
                'example' => fake()->randomElement(LibEducation::pluck('code')->toArray()),
            ],
            'weekly_income' => [
                'description' => 'weekly income of family composition',
                'example' => fake()->randomNumber(5, false),
            ],
            'school' => [
                'description' => 'school of family composition',
                'example' => fake()->name(),
            ],
            'company' => [
                'description' => 'company of family composition',
                'example' => fake()->name(),
            ],
            'contact_information' => [
                'description' => 'mobile number of family composition',
                'example' => fake()->phoneNumber(),
            ],
        ];
    }
}
