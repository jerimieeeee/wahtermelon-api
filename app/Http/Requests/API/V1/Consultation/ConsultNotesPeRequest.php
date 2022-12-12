<?php

namespace App\Http\Requests\API\V1\Consultation;

use App\Models\V1\Consultation\ConsultNotes;
use App\Models\V1\Libraries\LibPe;
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
        return [
            'notes_id' => 'required|exists:consult_notes,id',
            'physical_exam' => 'required|exists:lib_pes,pe_id',
        ];
    }

    public function bodyParameters()
    {
        return [
            'notes_id' => [
                'description' => 'ID of consult notes.',
                'example' => fake()->randomElement(ConsultNotes::pluck('id')->toArray()),
            ],
            'pe_id' => [
                'description' => 'class id of diagnoses',
                'example' => fake()->randomElement(LibPe::pluck('pe_id')->toArray()),
            ],
        ];
    }
}
