<?php

namespace App\Http\Requests\API\V1\Consultation;

use Illuminate\Foundation\Http\FormRequest;

class ConsultRequest extends FormRequest
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
            'patient_id' => 'required',
            'user_id' => 'required',
            'consult_end' => 'required|date|date_format:Y-m-d',
            'physician_id' => 'required',
            'consult_done' => 'required',
            'pt_group' => 'required',
        ];
    }
}
