<?php

namespace App\Http\Requests\API\V1\Consultation;

use App\Models\User;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Consultation\ConsultNotes;
use App\Models\V1\Libraries\LibComplaint;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
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
            'notes_id' => 'required|exists:consult_notes,id',
            'consult_id' => 'required|exists:consults,id',
            'patient_id' => 'required|exists:patients,id',
            'complaints' => 'array|exists:lib_complaints,complaint_id',
            // 'user_id' => 'required|exists:users,id',
            // 'facility_code' => 'nullable|exists:facilities,code',
        ];
    }

    public function bodyParameters()
    {
        return [
            'notes_id' => [
                'description' => 'ID of consult notes.',
                'example' => fake()->randomElement(ConsultNotes::pluck('id')->toArray()),
            ],
            'consult_id' => [
                'description' => 'ID of consultation',
                'example' => fake()->randomElement(Consult::pluck('id')->toArray()),
            ],
            'patient_id' => [
                'description' => 'ID of patient.',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'complaint_id' => [
                'description' => 'ID of complaint library',
                'example' => fake()->randomElement(LibComplaint::pluck('complaint_id')->toArray()),
            ],
            // 'user_id' => [
            //     'description' => 'ID of user',
            //     'example' => fake()->randomElement(User::pluck('id')->toArray()),
            // ],
            // 'facility_code' => [
            //     'description' => 'code of facility.',
            //     'example' => fake()->randomElement(Facility::pluck('code')->toArray()),
            // ],
        ];
    }
}
