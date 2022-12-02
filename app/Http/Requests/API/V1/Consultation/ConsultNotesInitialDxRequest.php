<?php

namespace App\Http\Requests\API\V1\Consultation;

use App\Models\User;
use App\Models\V1\Consultation\ConsultNotes;
use App\Models\V1\Libraries\LibDiagnosis;
use App\Models\V1\PSGC\Facility;
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
            'notes_id' => 'required|exists:consult_notes,id',
            'user_id' => 'required|exists:users,id',
            'facility_code' => 'required|exists:facilities,code',
            'idx.*.class_id' => 'required|exists:lib_diagnoses,class_id',
            'idx.*.idx_remark' => 'nullable',
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
            'facility_code' => [
                'description' => 'code of facility.',
                'example' => fake()->randomElement(Facility::pluck('code')->toArray()),
            ],
            'class_id' => [
                'description' => 'class id of diagnoses',
                'example' => fake()->randomElement(LibDiagnosis::pluck('class_id')->toArray()),
            ],
            'idx_remark' => [
                'description' => 'Remarks of Initial Dx',
                'example' => fake()->sentence(),
            ],
        ];

    }
}
