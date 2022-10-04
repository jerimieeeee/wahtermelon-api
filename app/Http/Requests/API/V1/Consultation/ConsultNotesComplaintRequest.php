<?php

namespace App\Http\Requests\API\V1\Consultation;

use Illuminate\Foundation\Http\FormRequest;

class ConsultNotesComplaintRequest extends FormRequest
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
            'notes_id' => 'required',
            'consult_id' => 'required',
            'patient_id' => 'required',
            'complaint_id' => 'required',
            'complaint_date' => 'required|date|date_format:Y-m-d|before:tomorrow',
            'user_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'complaint_date.before' => 'The complaint date must not be future date.'
        ];
    }

}
