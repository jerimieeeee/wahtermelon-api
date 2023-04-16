<?php

namespace App\Http\Requests\API\V1\Consultation;

use App\Models\User;
use App\Models\V1\Consultation\ConsultNotes;
use App\Models\V1\Libraries\LibIcd10;
use App\Models\V1\PSGC\Facility;
use Illuminate\Foundation\Http\FormRequest;

class ConsultNotesFinalDxRequest extends FormRequest
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
            // 'user_id' => 'required|exists:users,id',
            // 'facility_code' => 'nullable|exists:facilities,code',
            'final_diagnosis' => 'array|exists:lib_icd10s,icd10_code',
        ];
    }

    public function bodyParameters()
    {
        return [
            'notes_id' => [
                'description' => 'ID of consult notes.',
                'example' => fake()->randomElement(ConsultNotes::pluck('id')->toArray()),
            ],
            // 'user_id' => [
            //     'description' => 'ID of user',
            //     'example' => fake()->randomElement(User::pluck('id')->toArray()),
            // ],
            // 'facility_code' => [
            //     'description' => 'code of facility.',
            //     'example' => fake()->randomElement(Facility::pluck('code')->toArray()),
            // ],
            'icd10_code' => [
                'description' => 'Icd10 code of Final Dx',
                'example' => fake()->randomElement(LibIcd10::pluck('icd10_code')->toArray()),
            ],
        ];
    }
}
