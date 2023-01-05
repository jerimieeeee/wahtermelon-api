<?php

namespace App\Http\Requests\API\V1\Laboratory;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratory;
use App\Models\V1\Libraries\LibLaboratoryStatus;
use Illuminate\Foundation\Http\FormRequest;
use Laravel\Passport\Passport;

class ConsultLaboratoryCbcRequest extends FormRequest
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
            'patient_id' => 'required|exists:patients,id',
            'consult_id' => 'nullable|exists:consults,id',
            'request_id' => 'required|exists:consult_laboratories,id',
            'laboratory_date' => 'date|date_format:Y-m-d|before:tomorrow|required',
            'hemoglobin' => 'nullable',
            'hematocrit' => 'nullable',
            'rbc' => 'nullable',
            'mcv' => 'nullable',
            'mch' => 'nullable',
            'mchc' => 'nullable',
            'wbc' => 'nullable',
            'neutrophils' => 'nullable',
            'lymphocytes' => 'nullable',
            'basophils' => 'nullable',
            'monocytes' => 'nullable',
            'eosinophils' => 'nullable',
            'stab' => 'nullable',
            'juvenile' => 'nullable',
            'platelets' => 'nullable',
            'reticulocytes' => 'nullable',
            'bleeding_time' => 'nullable',
            'clothing_time' => 'nullable',
            'esr' => 'nullable',
            'remarks' => 'nullable',
            'lab_status_code' => 'required|exists:lib_laboratory_statuses,code',
        ];
    }

    public function bodyParameters()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        //$consult = ConsultLaboratory::whereLabCode('CBC')->inRandomOrder()->limit(1)->first();
        $consult = ConsultLaboratory::factory()->create(['lab_code' => 'CBC']);
        return [
            'facility_code' => [
                'example' => $consult->facility_code
            ],
            'user_id' => [
                'example' => $consult->user_id
            ],
            'patient_id' => [
                'example' => $consult->patient_id
            ],
            'consult_id' => [
                'example' => $consult->consult_id
            ],
            'laboratory_date' => [
                'example' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d')
            ],
            'request_id' => [
                'example' => $consult->id
            ],
            'hemoglobin' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'hematocrit' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'rbc' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'mcv' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'mch' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'mchc' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'wbc' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'neutrophils' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'lymphocytes' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'basophils' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'monocytes' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'eosinophils' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'stab' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'juvenile' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'platelets' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'reticulocytes' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'bleeding_time' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'clothing_time' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'esr' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'remarks' => [
                'example' => fake()->sentence()
            ],
            'lab_status_code' => [
                'example' => fake()->randomElement(LibLaboratoryStatus::pluck('code')->toArray())
            ],
        ];
    }
}
