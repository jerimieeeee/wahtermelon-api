<?php

namespace App\Http\Requests\API\V1;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'facility_code' => 'required|exists:facilities,code',
            'last_name' => 'required',
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'suffix_name' => 'required|exists:lib_suffix_names,code',
            'gender' => 'required',
            'birthdate' => 'required|date',
            'contact_number' => 'required|min:11|max:13', //'required|min:11|max:11|unique:users' . (request()->has('id') ? ',contact_number, ' . request()->input('id') : ''),
            //'username' => 'required|min:4|unique:users',// . (request()->has('id') ? ',username, ' . request()->input('id') : ''),
            'email' => 'nullable|email|unique:users' . (request()->has('id') ? ',email, ' . auth()->user()->id : ''),
            'is_active' => 'nullable|boolean',
            'photo_url' => 'nullable|url',
            'tin_number' => 'sometimes|max:9',
            'accreditation_number' => 'sometimes|max:14',
            'designation_code' => 'required|exists:lib_designations,code',
            'employer_code' => 'required|exists:lib_employers,code',
        ];
    }

}
