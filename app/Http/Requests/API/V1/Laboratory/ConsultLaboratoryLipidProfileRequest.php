<?php

namespace App\Http\Requests\API\V1\Laboratory;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratory;
use App\Models\V1\Libraries\LibLaboratoryStatus;
use App\Models\V1\PSGC\Facility;
use Illuminate\Foundation\Http\FormRequest;
use Laravel\Passport\Passport;

class ConsultLaboratoryLipidProfileRequest extends FormRequest
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
            'referral_facility' => 'nullable',
            'ldl' => 'nullable',
            'hdl' => 'nullable',
            'cholesterol' => 'nullable',
            'triglycerides' => 'nullable',
            'remarks' => 'nullable',
            'lab_status_code' => 'required|exists:lib_laboratory_statuses,code',
        ];
    }

    public function bodyParameters()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $consult = ConsultLaboratory::factory()->create(['lab_code' => 'LPFL']);

        return [
            'facility_code' => [
                'example' => $consult->facility_code,
            ],
            'consult_id' => [
                'example' => $consult->consult_id,
            ],
            'patient_id' => [
                'example' => $consult->patient_id,
            ],
            'user_id' => [
                'example' => $consult->user_id,
            ],
            'request_id' => [
                'example' => $consult->id,
            ],
            'laboratory_date' => [
                'example' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d'),
            ],
            'referral_facility' => [
                'example' => fake()->randomElement(Facility::pluck('code')->toArray()),
            ],
            'ldl' => [
                'example' => fake()->numberBetween(1, 10),
            ],
            'hdl' => [
                'example' => fake()->numberBetween(1, 10),
            ],
            'cholesterol' => [
                'example' => fake()->numberBetween(1, 10),
            ],
            'triglycerides' => [
                'example' => fake()->numberBetween(1, 10),
            ],
            'remarks' => [
                'example' => fake()->sentence(),
            ],
            'lab_status_code' => [
                'example' => fake()->randomElement(LibLaboratoryStatus::pluck('code')->toArray()),
            ],
        ];
    }
}
