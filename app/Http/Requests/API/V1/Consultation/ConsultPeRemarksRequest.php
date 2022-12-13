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
            'heart_remarks' => 'nullable',
            'abdomen_remarks' => 'nullable',
            'extremities_remarks' => 'nullable',
            'breast_remarks' => 'nullable',
            'pelvic_remarks' => 'nullable',
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
                'description' => 'remarks of consult_pe_remarks skin',
                'example' => fake()->sentence(),
            ],
            'heent_remarks' => [
                'description' => 'remarks of consult_pe_remarks heent',
                'example' => fake()->sentence(),
            ],
            'chest_remarks' => [
                'description' => 'remarks of consult_pe_remarks chest',
                'example' => fake()->sentence(),
            ],
            'heart_remarks' => [
                'description' => 'remarks of consult_pe_remarks heart',
                'example' => fake()->sentence(),
            ],
            'abdomen_remarks' => [
                'description' => 'remarks of consult_pe_remarks abdomen',
                'example' => fake()->sentence(),
            ],
            'extremities_remarks' => [
                'description' => 'remarks of consult_pe_remarks extremities',
                'example' => fake()->sentence(),
            ],
            'breast_remarks' => [
                'description' => 'remarks of consult_pe_remarks breast',
                'example' => fake()->sentence(),
            ],
            'pelvic_remarks' => [
                'description' => 'remarks of consult_pe_remarks pelvic',
                'example' => fake()->sentence(),
            ],
            'neuro_remarks' => [
                'description' => 'remarks of consult_pe_remarks neuro',
                'example' => fake()->sentence(),
            ],
            'rectal_remarks' => [
                'description' => 'remarks of consult_pe_remarks rectal',
                'example' => fake()->sentence(),
            ],
            'genitourinary_remarks' => [
                'description' => 'remarks of consult_pe_remarks genitourinary',
                'example' => fake()->sentence(),
            ],
        ];

    }
}
