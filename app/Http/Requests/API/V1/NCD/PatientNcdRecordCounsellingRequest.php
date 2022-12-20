<?php

namespace App\Http\Requests\API\V1\NCD;

use App\Models\V1\Libraries\LibNcdRecordCounselling;
use App\Models\V1\NCD\ConsultNcdRiskAssessment;
use App\Models\V1\NCD\PatientNcdRecord;
use Illuminate\Foundation\Http\FormRequest;

class PatientNcdRecordCounsellingRequest extends FormRequest
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
            'patient_ncd_record_id' => 'required|exists:patient_ncd_records,id',
            'consult_ncd_risk_id' => 'required|exists:consult_ncd_risk_assessment,id',
            'counselling_code' => 'required|exists:lib_ncd_record_counsellings,id',
        ];
    }

    public function bodyParameters()
    {
        return [
            'patient_ncd_record_id' => [
                'description' => 'ID of patient ncd record',
                'example' => fake()->randomElement(PatientNcdRecord::pluck('id')->toArray()),
            ],
            'consult_ncd_risk_id' => [
                'description' => 'ID of consult ncd risk assessment',
                'example' => fake()->randomElement(ConsultNcdRiskAssessment::pluck('id')->toArray()),
            ],
            'counselling_code' => [
                'description' => 'ID of lib ncd record counselling',
                'example' => fake()->randomElement(LibNcdRecordCounselling::pluck('id')->toArray()),
            ],
        ];
    }
}
