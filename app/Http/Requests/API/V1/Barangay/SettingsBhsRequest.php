<?php

namespace App\Http\Requests\API\V1\Barangay;

use Illuminate\Foundation\Http\FormRequest;

class SettingsBhsRequest extends FormRequest
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
            'bhs_name' => 'required',
            'assigned_user_id' => 'required|exists:users,id',
            'barangay_code' => 'required|exists:barangays,psgc_10_digit_code',
            'barangay' => 'required|array',
        ];
    }
}
