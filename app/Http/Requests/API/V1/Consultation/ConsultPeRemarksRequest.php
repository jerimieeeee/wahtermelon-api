<?php

namespace App\Http\Requests\API\V1\Consultation;

use App\Models\V1\Consultation\ConsultNotes;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Http\FormRequest;

class ConsultPeRemarksRequest extends FormRequest
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
            'notes_id' => 'required|exists:consults,id',
            'patient_id' => 'required|exists:patients,id',
            'skin_remarks' => 'nullable',
            'heent_remarks' => 'nullable',
            'chest_remarks' => 'nullable',
            'neuro_remarks' => 'nullable',
            'rectal_remarks' => 'nullable',
            'genitourinary_remarks' => 'nullable',
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
            'skin_remarks' => [
                'description' => 'remarks of consult_pe_remarks',
                'example' => fake()->sentence(),
            ],
            'heent_remarks' => [
                'description' => 'remarks of consult_pe_remarks',
                'example' => fake()->sentence(),
            ],
            'chest_remarks' => [
                'description' => 'remarks of consult_pe_remarks',
                'example' => fake()->sentence(),
            ],
            'neuro_remarks' => [
                'description' => 'remarks of consult_pe_remarks',
                'example' => fake()->sentence(),
            ],
            'rectal_remarks' => [
                'description' => 'remarks of consult_pe_remarks',
                'example' => fake()->sentence(),
            ],
            'genitourinary_remarks' => [
                'description' => 'remarks of consult_pe_remarks',
                'example' => fake()->sentence(),
            ],
        ];

    }
}
