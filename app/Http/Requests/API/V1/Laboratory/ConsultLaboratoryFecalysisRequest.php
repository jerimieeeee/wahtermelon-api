<?php

namespace App\Http\Requests\API\V1\Laboratory;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratory;
use App\Models\V1\Libraries\LibLaboratoryBloodInStool;
use App\Models\V1\Libraries\LibLaboratoryStatus;
use App\Models\V1\Libraries\LibLaboratoryStoolColor;
use App\Models\V1\Libraries\LibLaboratoryStoolConsistency;
use Illuminate\Foundation\Http\FormRequest;
use Laravel\Passport\Passport;

class ConsultLaboratoryFecalysisRequest extends FormRequest
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
            'consult_id' => 'nullable|exists:consults,id',
            'patient_id' => 'required|exists:patients,id',
            'request_id' => 'required|exists:consult_laboratories,id',
            'laboratory_date' => 'date|date_format:Y-m-d|before:tomorrow|required',
            'color_code' => 'required|exists:lib_laboratory_stool_colors,code',
            'consistency_code' => 'required|exists:lib_laboratory_stool_colors,code',
            'rbc' => 'nullable',
            'wbc' => 'nullable',
            'ova' => 'nullable',
            'parasite' => 'nullable',
            'blood_code' => 'required|exists:lib_laboratory_blood_in_stools,code',
            'pus_cells' => 'nullable',
            'remarks' => 'nullable',
            'lab_status_code' => 'required|exists:lib_laboratory_statuses,code',
        ];
    }

    public function bodyParameters()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $consult = ConsultLaboratory::factory()->create(['lab_code' => 'FCAL']);
        return [
            'facility_code' => [
                'example' => $consult->facility_code
            ],
            'consult_id' => [
                'example' => $consult->consult_id
            ],
            'patient_id' => [
                'example' => $consult->patient_id
            ],
            'user_id' => [
                'example' => $consult->user_id
            ],
            'request_id' => [
                'example' => $consult->id
            ],
            'laboratory_date' => [
                'example' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d')
            ],
            'color_code' => [
                'example' => fake()->randomElement(LibLaboratoryStoolColor::pluck('code')->toArray())
            ],
            'consistency_code' => [
                'example' => fake()->randomElement(LibLaboratoryStoolConsistency::pluck('code')->toArray())
            ],
            'rbc' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'wbc' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'ova' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'parasite' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'blood_code' => [
                'example' => fake()->randomElement(LibLaboratoryBloodInStool::pluck('code')->toArray())
            ],
            'pus_cells' => [
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
