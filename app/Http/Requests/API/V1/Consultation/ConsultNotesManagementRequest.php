<?php

namespace App\Http\Requests\API\V1\Consultation;

use App\Models\V1\Consultation\ConsultNotes;
use App\Models\V1\Libraries\LibManagement;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Http\FormRequest;

class ConsultNotesManagementRequest extends FormRequest
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
            'patient_id' => 'required|exists:patients,id',
            'management.*.management_code' => 'required|exists:lib_management,code',
            'management.*.remarks' => 'nullable',
        ];
    }

    public function bodyParameters()
    {
        return [
            'notes_id' => [
                'description' => 'ID of consult notes.',
                'example' => fake()->randomElement(ConsultNotes::pluck('id')->toArray()),
            ],
            'patient_id' => [
                'description' => 'ID of patient.',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'management_code' => [
                'description' => 'code of lib management',
                'example' => fake()->randomElement(LibManagement::pluck('code')->toArray()),
            ],
            'remarks' => [
                'description' => 'remarks of management',
                'example' => fake()->sentence(),
            ],
        ];
    }
}
