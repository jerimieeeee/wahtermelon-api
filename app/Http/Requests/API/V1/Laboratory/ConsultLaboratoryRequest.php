<?php

namespace App\Http\Requests\API\V1\Laboratory;

use App\Models\User;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Libraries\LibLaboratory;
use App\Models\V1\Libraries\LibLaboratoryRecommendation;
use App\Models\V1\Libraries\LibLaboratoryRequestStatus;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Http\FormRequest;

class ConsultLaboratoryRequest extends FormRequest
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
            'request_date' => 'date|date_format:Y-m-d|before:tomorrow|required',
            'lab_code' => 'required|exists:lib_laboratories,code',
            'recommendation_code' => 'required|exists:lib_laboratory_recommendations,code',
            'request_status_code' => 'required|exists:lib_laboratory_request_statuses,code',
        ];
    }

    public function bodyParameters()
    {
        return [
            'patient_id' => [
                'description' => 'ID of patient',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'request_date' => [
                'example' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d'),
            ],
            'consult_id' => [
                'example' => fake()->randomElement(Consult::pluck('id')->toArray()),
            ],
            'lab_code' => [
                'example' => fake()->randomElement(LibLaboratory::pluck('code')->toArray()),
            ],
            'recommendation_code' => [
                'example' => fake()->randomElement(LibLaboratoryRecommendation::pluck('code')->toArray()),
            ],
            'request_status_code' => [
                'example' => fake()->randomElement(LibLaboratoryRequestStatus::pluck('code')->toArray()),
            ],
        ];
    }
}
