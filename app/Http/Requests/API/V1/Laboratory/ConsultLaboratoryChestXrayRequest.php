<?php

namespace App\Http\Requests\API\V1\Laboratory;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratory;
use App\Models\V1\Libraries\LibLaboratoryChestxrayFindings;
use App\Models\V1\Libraries\LibLaboratoryChestxrayObservation;
use App\Models\V1\Libraries\LibLaboratoryStatus;
use App\Models\V1\PSGC\Facility;
use Illuminate\Foundation\Http\FormRequest;
use Laravel\Passport\Passport;

class ConsultLaboratoryChestXrayRequest extends FormRequest
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
            'referral_facility' => 'nullable',
            'findings_code' => 'nullable|exists:lib_laboratory_chestxray_findings,code',
            'remarks_findings' => 'required_if:findings_code,99',
            'observation_code' => 'nullable|exists:lib_laboratory_chestxray_observations,code',
            'remarks_observation' => 'required_if:observation_code,99',
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
        $consult = ConsultLaboratory::factory()->create(['lab_code' => 'CXRAY']);
        $findings = fake()->randomElement(LibLaboratoryChestxrayFindings::pluck('code')->toArray());
        $observation = fake()->randomElement(LibLaboratoryChestxrayObservation::pluck('code')->toArray());

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
            'findings_code' => [
                'example' => $findings,
            ],
            'remarks_findings' => [
                'example' => $findings == '99' ? fake()->sentence() : null,
            ],
            'observation_code' => [
                'example' => $observation,
            ],
            'remarks_observation' => [
                'example' => $observation == '99' ? fake()->sentence() : null,
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
