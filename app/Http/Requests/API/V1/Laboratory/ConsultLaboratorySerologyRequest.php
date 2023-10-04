<?php

namespace App\Http\Requests\API\V1\Laboratory;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratory;
use App\Models\V1\Libraries\LibLaboratoryStatus;
use App\Models\V1\Libraries\LibLaboratoryUltrasoundType;
use App\Models\V1\PSGC\Facility;
use Illuminate\Foundation\Http\FormRequest;
use Laravel\Passport\Passport;

class ConsultLaboratorySerologyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'consult_id' => 'nullable|exists:consults,id',
            'request_id' => 'required|exists:consult_laboratories,id',
            'laboratory_date' => 'date|date_format:Y-m-d|before:tomorrow|required',
            'referral_facility' => 'nullable',

            'hiv' => 'nullable',
            'hcv' => 'nullable',
            'anti_streptolysin' => 'nullable',
            'reactive_protein' => 'nullable',
            'rheumatoid_factor' => 'nullable',
            'rapid_plasma' => 'nullable',

            'result' => 'nullable',
            'remarks' => 'nullable',
            'lab_status_code' => 'required|exists:lib_laboratory_statuses,code',
        ];
    }

    public function bodyParameters()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $consult = ConsultLaboratory::factory()->create(['lab_code' => 'RBS']);

        return [
            'facility_code' => [
                'example' => $consult->facility_code,
            ],
            'user_id' => [
                'example' => $consult->user_id,
            ],
            'patient_id' => [
                'example' => $consult->patient_id,
            ],
            'consult_id' => [
                'example' => $consult->consult_id,
            ],
            'laboratory_date' => [
                'example' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d'),
            ],
            'referral_facility' => [
                'example' => fake()->randomElement(Facility::pluck('code')->toArray()),
            ],
            'request_id' => [
                'example' => $consult->id,
            ],
            'hiv' => [
                'example' => fake()->words(2),
            ],
            'hcv' => [
                'example' => fake()->words(2),
            ],
            'anti_streptolysin' => [
                'example' => fake()->words(2),
            ],
            'reactive_protein' => [
                'example' => fake()->words(2),
            ],
            'rheumatoid_factor' => [
                'example' => fake()->words(2),
            ],
            'rapid_plasma' => [
                'example' => fake()->words(2),
            ],
            'result' => [
                'example' => fake()->sentence(),
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
