<?php

namespace App\Http\Requests\API\V1\Laboratory;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratory;
use App\Models\V1\Libraries\LibLaboratoryMtbResult;
use App\Models\V1\Libraries\LibLaboratoryRifResult;
use App\Models\V1\Libraries\LibLaboratoryStatus;
use App\Models\V1\Libraries\LibLaboratoryUltrasoundType;
use App\Models\V1\PSGC\Facility;
use Illuminate\Foundation\Http\FormRequest;
use Laravel\Passport\Passport;

class ConsultLaboratoryGeneXpertRequest extends FormRequest
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

            'collection_date' => 'date|date_format:Y-m-d|before:tomorrow|required',
            'release_date' => 'date|date_format:Y-m-d|before:tomorrow|required',
            'mtb_code' => 'required|exists:lib_laboratory_mtb_results,code',
            'rif_code' => 'required|exists:lib_laboratory_rif_results,code',
            'specimen_code' => 'required',

            'remarks' => 'nullable',
            'lab_status_code' => 'required|exists:lib_laboratory_statuses,code',
        ];
    }

    public function bodyParameters()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $consult = ConsultLaboratory::factory()->create(['lab_code' => 'GXPT']);

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
            'collection_date' => [
                'example' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d'),
            ],
            'release_date' => [
                'example' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d'),
            ],
            'mtb' => [
                'example' => fake()->randomElement(LibLaboratoryMtbResult::pluck('code')->toArray()),
            ],
            'rif' => [
                'example' => fake()->randomElement(LibLaboratoryRifResult::pluck('code')->toArray()),
            ],
            'specimen_code' => [
                'example' => fake()->text(20),
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
