<?php

namespace App\Http\Requests\API\V1\Consultation;

use Illuminate\Foundation\Http\FormRequest;

class ConsultNotesPeRequest extends FormRequest
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
        // return [
        //     'notes_id' => 'required|exists:patients,id',
        //     'patient_id' => 'required|exists:patients,id',
        //     'user_id' => 'required|exists:users,id',
        //     'birth_weight' => 'required',
        //     'mothers_id' => 'required|exists:patient,id',
        //     'ccdev_ended' => 'required|boolean',
        //     'admission_date' => 'required|date|date_format:Y-m-d',
        //     'discharge_date' => 'required|date|date_format:Y-m-d',
        // ];
    }
}
