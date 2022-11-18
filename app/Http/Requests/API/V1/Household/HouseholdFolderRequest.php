<?php

namespace App\Http\Requests\API\V1\Household;

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
            'facility_code' => 'exists:facilities,code',
            'user_id' => 'required|exists:users,id',
            'address' => 'required',
            'barangay_code' => 'required|exists:barangays,code',
            'cct_date' => 'date|date_format:Y-m-d|before:tomorrow|nullable',
            'cct_id' => 'nullable'
        ];
    }
}
