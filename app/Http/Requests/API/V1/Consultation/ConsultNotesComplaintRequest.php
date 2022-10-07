<?php

namespace App\Http\Requests\API\V1\Consultation;

use App\Models\User;
use App\Models\V1\Consultation\ConsultNotes;
use App\Models\V1\Libraries\LibComplaint;
use App\Models\V1\Patient\Patient;
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


    public function bodyParameters()
    {
        return [
            'notes_id' => [
                'description' => 'ID of consult notes.',
                'example' => fake()->randomElement(ConsultNotes::pluck('id')->toArray()),
            ],
            'consult_id' => [
                'description' => 'ID of consultation',
                'example' => fake()->randomElement(LibComplaint::pluck('id')->toArray()),
            ],
            'patient_id' => [
                'description' => 'ID of patient.',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'complaint_id' => [
                'description' => 'ID of complaint library',
                'example' => fake()->randomElement(LibComplaint::pluck('id')->toArray()),
            ],
            'complaint_date' => [
                'description' => 'Date of complaint.',
                'example' => fake()->date($format = 'Y-m-d', $max = 'now'),
            ],
            'user_id' => [
                'description' => 'ID of user',
                'example' => fake()->randomElement(User::pluck('id')->toArray()),
            ],
        ];

    }


}
