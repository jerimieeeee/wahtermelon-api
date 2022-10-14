<?php

namespace App\Http\Requests\API\V1\Childcare;

use Illuminate\Foundation\Http\FormRequest;

class ConsultCcdevVaccineRequest extends FormRequest
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
            'patient_ccdev_id' => 'required|exists:ccdevs,id',
            'patient_id' => 'required|exists:patients,id',
            'user_id' => 'required|exists:users,id',
            'vaccine_id' => 'required|exists:lib_vaccines,vaccine_id',
            'vaccine_date' => 'nullable|date|date_format:Y-m-d',
        ];
    }
}
