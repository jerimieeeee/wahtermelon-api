<?php

namespace App\Http\Requests\API\V1\Patient;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
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
            'facility_id' => 'sometimes|exists:facilities,id',
            'last_name' => 'required',
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'suffix_name' => 'required|exists:lib_suffix_names,suffix_code',
            'birthdate' => 'required|date|date_format:Y-m-d|before:tomorrow',
            'mothers_name' => 'required',
            'gender' => 'required',
            'mobile_number' => 'required|min:11|max:13',
            'pwd_status_code' => 'exists:lib_pwd_types,type_code',
            'indegenous_flag' => 'required|boolean',
            'blood_type' => 'sometimes|exists:lib_blood_types,blood_type',
            'religion_code' => 'required|exists:lib_religions,religion_code',
            'occupation_code' => 'required|exists:lib_occupations,occupation_code',
            'education_id' => 'required|exists:lib_education,education_id',
            'civil_status_id' => 'required|exists:lib_civil_statuses,status_id',
            'consent_flag' => 'required|boolean',
            'image_url' => 'nullable|url',
        ];
    }

    public function messages()
    {
        return [
            'birthdate.before' => 'The birthdate must not be future date.'
        ];
    }

}
