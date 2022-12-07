<?php

namespace App\Http\Requests\API\V1\MaternalCare;

use App\Models\V1\Libraries\LibMcService;
use App\Models\V1\Libraries\LibMcVisitType;
use App\Models\V1\MaternalCare\PatientMc;
use Illuminate\Foundation\Http\FormRequest;

class ConsultMcServiceRequest extends FormRequest
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
    public function validatedWithCasts(): array
    {
        $visitStatus = "Prenatal";
        $data = PatientMc::whereId(request()->patient_mc_id)->whereHas('postpartum')->first();

        if($data) {
            $visitStatus = "Postpartum";
        }

        return array_merge($this->validated(), [
            'visit_status' => $visitStatus,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'patient_mc_id' => 'required|exists:patient_mc,id',
            //'facility_code' => 'exists:facilities,code',
            'patient_id' => 'required|exists:patients,id',
            //'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:lib_mc_services,id',
            'visit_type_code' => 'required|exists:lib_mc_visit_types,code',
            'visit_status' => 'required',
            'service_date' => 'date|date_format:Y-m-d|before:tomorrow|required',
            'service_qty' => 'numeric',
            'positive_result' => 'boolean',
            'intake_penicillin' => 'boolean'
        ];
    }

    public function bodyParameters()
    {
        $mcId = PatientMc::whereHas('preRegister')->orWhereHas('postRegister')->inRandomOrder()->limit(1)->first();
        return [
            'patient_mc_id' => [
                'description' => 'ID of maternal care record',
                'example' => $mcId->id,
            ],
            'patient_id' => [
                'description' => 'ID of patient',
                'example' => $mcId->patient_id,
            ],
            'service_id' => [
                'example' => fake()->randomElement(LibMcService::pluck('id')->toArray())
            ],
            'visit_type_code' => [
                'example' => fake()->randomElement(LibMcVisitType::pluck('code')->toArray())
            ],
            'visit_status' => [
                'example' => fake()->randomElement(['Prenatal', 'Postpartum'])
            ],
            'service_date' => [
                'example' => fake()->date('Y-m-d')
            ],
            'service_qty' => [
                'example' => fake()->numberBetween(1, 100)
            ],
        ];
    }
}
