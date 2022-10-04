<?php

namespace App\Http\Requests\API\V1\Consultation;

use Illuminate\Foundation\Http\FormRequest;

class ConsultNotesInitialDxRequest extends FormRequest
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
            'user_id' => 'required',
            'class_id' => 'required',
            'dx_remarks' => 'nullable',
        ];
    }
}
