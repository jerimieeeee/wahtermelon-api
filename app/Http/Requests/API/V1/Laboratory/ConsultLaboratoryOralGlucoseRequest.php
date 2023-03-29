<?php

namespace App\Http\Requests\API\V1\Laboratory;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratory;
use App\Models\V1\Libraries\LibLaboratoryStatus;
use App\Models\V1\PSGC\Facility;
use Illuminate\Foundation\Http\FormRequest;
use Laravel\Passport\Passport;

class ConsultLaboratoryOralGlucoseRequest extends FormRequest
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
            'fasting_exam_mg' => 'nullable',
            'fasting_exam_mmol' => 'nullable',
            'ogtt_one_hour_mg' => 'nullable',
            'ogtt_one_hour_mmol' => 'nullable',
            'ogtt_two_hour_mg' => 'nullable',
            'ogtt_two_hour_mmol' => 'nullable',
            'remarks' => 'nullable',
            'lab_status_code' => 'required|exists:lib_laboratory_statuses,code',
        ];
    }

    public function bodyParameters()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $consult = ConsultLaboratory::factory()->create(['lab_code' => 'OGTT']);

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
            'fasting_exam_mg' => [
                'example' => fake()->numberBetween(1, 10),
            ],
            'fasting_exam_mmol' => [
                'example' => fake()->numberBetween(1, 10),
            ],
            'ogtt_one_hour_mg' => [
                'example' => fake()->numberBetween(1, 10),
            ],
            'ogtt_one_hour_mmol' => [
                'example' => fake()->numberBetween(1, 10),
            ],
            'ogtt_two_hour_mg' => [
                'example' => fake()->numberBetween(1, 10),
            ],
            'ogtt_two_hour_mmol' => [
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
