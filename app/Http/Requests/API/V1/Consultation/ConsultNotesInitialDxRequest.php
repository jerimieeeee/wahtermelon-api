<?php

namespace App\Http\Requests\API\V1\Consultation;

use App\Models\User;
use App\Models\V1\Consultation\ConsultNotes;
use App\Models\V1\Libraries\LibDiagnosis;
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

    public function bodyParameters()
    {
        return [
            'notes_id' => [
                'description' => 'ID of consult notes.',
                'example' => fake()->randomElement(ConsultNotes::pluck('id')->toArray()),
            ],
            'user_id' => [
                'description' => 'ID of user',
                'example' => fake()->randomElement(User::pluck('id')->toArray()),
            ],
            'class_id' => [
                'description' => 'class id code of diagnoses',
                'example' => fake()->randomElement(LibDiagnosis::pluck('id')->toArray()),
            ],
            'dx_remarks' => [
                'description' => 'Remarks of Initial Dx',
                'example' => fake()->sentence(),
            ],
        ];

    }
}
