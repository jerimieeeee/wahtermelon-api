<?php

namespace App\Http\Requests\API\V1\Laboratory;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratory;
use App\Models\V1\Libraries\LibLaboratoryFindings;
use App\Models\V1\Libraries\LibLaboratoryResult;
use App\Models\V1\Libraries\LibLaboratorySputumCollection;
use App\Models\V1\Libraries\LibLaboratoryStatus;
use App\Models\V1\PSGC\Facility;
use Illuminate\Foundation\Http\FormRequest;
use Laravel\Passport\Passport;

class ConsultLaboratorySputumRequest extends FormRequest
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
            'visual_appearance' => 'nullable',
            'reading' => 'nullable',
            'data_collection_code' => 'nullable|exists:lib_laboratory_sputum_collections,code',
            'findings_code' => 'nullable|exists:lib_laboratory_findings,code',
            'remarks' => 'nullable',
            'lab_status_code' => 'required|exists:lib_laboratory_statuses,code',
        ];
    }

    public function bodyParameters()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $consult = ConsultLaboratory::factory()->create(['lab_code' => 'SPTM']);
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
            'referral_facility' => [
                'example' => fake()->randomElement(Facility::pluck('code')->toArray())
            ],
            'request_id' => [
                'example' => $consult->id
            ],
            'visual_appearance' => [
                'example' => fake()->sentence()
            ],
            'reading' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'data_collection_code' => [
                'example' => fake()->randomElement(LibLaboratorySputumCollection::pluck('code')->toArray())
            ],
            'findings_code' => [
                'example' => fake()->randomElement(LibLaboratoryFindings::pluck('code')->toArray())
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
