<?php

namespace App\Http\Requests\API\V1;

use App\Models\User;
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
    /*public function rules()
    {
        $userId = $this->route('user'); // Assuming you pass the user ID in the route
        $user = User::find($userId);
        //$isActiveChanged = $user && $user->is_active != $this->input('is_active');

        return [
            'facility_code' => 'required|exists:facilities,code',
            'last_name' => 'required',
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'suffix_name' => 'required|exists:lib_suffix_names,code',
            'gender' => 'required',
            'birthdate' => 'required|date',
            'contact_number' => $this->input('contact_number') !== $user->contact_number ? 'required|min:11|max:13' : 'nullable', //'required|min:11|max:11|unique:users' . (request()->has('id') ? ',contact_number, ' . request()->input('id') : ''),
            //'username' => 'required|min:4|unique:users',// . (request()->has('id') ? ',username, ' . request()->input('id') : ''),
            'email' => 'nullable|email|unique:users'.(request()->has('id') ? ',email, '.auth()->user()->id : ''),
            'is_active' => 'nullable|boolean',
            'photo_url' => 'nullable|url',
            'tin_number' => 'sometimes|max:9',
            'accreditation_number' => 'sometimes|max:14',
            'designation_code' => 'required|exists:lib_designations,code',
            'employer_code' => 'required|exists:lib_employers,code',
            'attendant_cc_flag' => 'boolean|nullable',
            'attendant_mc_flag' => 'boolean|nullable',
            'attendant_tb_flag' => 'boolean|nullable',
            'attendant_ab_flag' => 'boolean|nullable',
            'attendant_ml_flag' => 'boolean|nullable',
            'attendant_fp_flag' => 'boolean|nullable',
            'attendant_cv_flag' => 'boolean|nullable',
        ];
    }*/
    public function rules()
    {
        $user = $this->route('user'); // Assuming you pass the user ID in the route
        //$user = User::find($userId)->first();
        $rules = [];

        if (request()->has('facility_code') && $this->input('facility_code') !== $user->facility_code) {
            $rules['facility_code'] = 'required|exists:facilities,code';
        }

        if (request()->has('last_name') && $this->input('last_name') !== $user->last_name) {
            $rules['last_name'] = 'required';
        }

        if (request()->has('first_name') && $this->input('first_name') !== $user->first_name) {
            $rules['first_name'] = 'required';
        }

        if (request()->has('middle_name') && $this->input('middle_name') !== $user->middle_name) {
            $rules['middle_name'] = 'nullable';
        }

        if (request()->has('suffix_name') && $this->input('suffix_name') !== $user->suffix_name) {
            $rules['suffix_name'] = 'required|exists:lib_suffix_names,code';
        }

        if (request()->has('gender') && $this->input('gender') !== $user->gender) {
            $rules['gender'] = 'required';
        }

        if (request()->has('birthdate') && $this->input('birthdate') !== $user->birthdate) {
            $rules['birthdate'] = 'required|date';
        }

        if (request()->has('contact_number') && $this->input('contact_number') !== $user->contact_number) {
            $rules['contact_number'] = 'required|min:11|max:13';
        }

        if (request()->has('email') && $this->input('email') !== $user->email) {
            $rules['email'] = 'nullable|email|unique:users' . ($user->id ? ',email,' . $user->id : '');
        }

        if (request()->has('is_active') && $this->input('is_active') !== $user->is_active) {
            $rules['is_active'] = 'nullable|boolean';
            //$rules['contact_number'] = 'nullable|min:11|max:13'; // Make contact_number nullable if is_active changed
        }

        if (request()->has('reports_flag') && $this->input('reports_flag') !== $user->reports_flag) {
            $rules['reports_flag'] = 'nullable|boolean';
            // 'reports_flag' => 'nullable|boolean', $rules['contact_number'] = 'nullable|min:11|max:13'; // Make contact_number nullable if is_active changed
        }

        if (request()->has('photo_url') && $this->input('photo_url') !== $user->photo_url) {
            $rules['photo_url'] = 'nullable|url';
        }

        if (request()->has('tin_number') && $this->input('tin_number') !== $user->tin_number) {
            $rules['tin_number'] = 'sometimes|max:9';
        }

        if (request()->has('accreditation_number') && $this->input('accreditation_number') !== $user->accreditation_number) {
            $rules['accreditation_number'] = 'sometimes|max:14';
        }

        if (request()->has('prc_number') && $this->input('prc_number') !== $user->prc_number) {
            $rules['prc_number'] = 'sometimes';
        }

        if (request()->has('designation_code') && $this->input('designation_code') !== $user->designation_code) {
            $rules['designation_code'] = 'required|exists:lib_designations,code';
        }

        if (request()->has('employer_code') && $this->input('employer_code') !== $user->employer_code) {
            $rules['employer_code'] = 'required|exists:lib_employers,code';
        }

        if (request()->has('attendant_cc_flag') && $this->input('attendant_cc_flag') !== $user->attendant_cc_flag) {
            $rules['attendant_cc_flag'] = 'boolean|nullable';
        }

        if (request()->has('attendant_mc_flag') && $this->input('attendant_mc_flag') !== $user->attendant_mc_flag) {
            $rules['attendant_mc_flag'] = 'boolean|nullable';
        }

        if (request()->has('attendant_tb_flag') && $this->input('attendant_tb_flag') !== $user->attendant_tb_flag) {
            $rules['attendant_tb_flag'] = 'boolean|nullable';
        }

        if (request()->has('attendant_ab_flag') && $this->input('attendant_ab_flag') !== $user->attendant_ab_flag) {
            $rules['attendant_ab_flag'] = 'boolean|nullable';
        }

        if (request()->has('attendant_ml_flag') && $this->input('attendant_ml_flag') !== $user->attendant_ml_flag) {
            $rules['attendant_ml_flag'] = 'boolean|nullable';
        }

        if (request()->has('attendant_fp_flag') && $this->input('attendant_fp_flag') !== $user->attendant_fp_flag) {
            $rules['attendant_fp_flag'] = 'boolean|nullable';
        }

        if (request()->has('attendant_cv_flag') && $this->input('attendant_cv_flag') !== $user->attendant_cv_flag) {
            $rules['attendant_cv_flag'] = 'boolean|nullable';
        }

        return $rules;
    }

}
