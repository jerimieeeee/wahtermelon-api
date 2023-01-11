<?php

namespace App\Http\Requests\API\V1\Patient;

use App\Models\V1\Libraries\LibNcdAnswerS2;
use App\Models\V1\Libraries\LibPregnancyDeliveryType;
use App\Models\V1\MaternalCare\PatientMcPostRegistration;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Http\FormRequest;

class PatientPregnancyHistoryRequest extends FormRequest
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
            // 'post_partum_id' => 'required|exists:patient_mc_post_registrations,id',
            'gravidity' => 'numeric|nullable',
            'parity' => 'numeric|nullable',
            'full_term' => 'numeric|nullable',
            'preterm' => 'numeric|nullable',
            'abortion' => 'numeric|nullable',
            'livebirths' => 'numeric|nullable',
            'delivery_type' => 'required|exists:lib_pregnancy_delivery_types,code',
            'induced_hypertension' => 'required|exists:lib_ncd_answer_s2,id',
            'with_family_planning' => 'required|exists:lib_ncd_answer_s2,id',
        ];
    }

    public function bodyParameters()
    {
        return [
            'patient_id' => [
                'description' => 'ID of patient.',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            // 'post_partum_id' => [
            //     'description' => 'ID of Maternal Care Post Partum',
            //     'example' => fake()->randomElement(PatientMcPostRegistration::pluck('id')->toArray()),
            // ],
            'gravidity' => [
                'description' => 'Patient Gravidity',
                'example' => fake()->randomNumber(2, true),
            ],
            'parity' => [
                'description' => 'Patient Parity',
                'example' => fake()->randomNumber(2, true),
            ],
            'full_term' => [
                'description' => 'Patient Full Term',
                'example' => fake()->randomNumber(2, true),
            ],
            'preterm' => [
                'description' => 'Patient Pre Term',
                'example' => fake()->randomNumber(2, true),
            ],
            'abortion' => [
                'description' => 'Patient Abortion',
                'example' => fake()->randomNumber(2, true),
            ],
            'livebirths' => [
                'description' => 'Patient Live Birth',
                'example' => fake()->randomNumber(2, true),
            ],
            'delivery_type' => [
                'description' => 'Pregnancy delivery type',
                'example' => fake()->randomElement(LibPregnancyDeliveryType::pluck('code')->toArray()),
            ],
            'induced_hypertension' => [
                'description' => 'Is patient induced hypertension during pregnancy?',
                'example' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            ],
            'with_family_planning' => [
                'description' => 'Is patient with family planning?',
                'example' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            ],
        ];
    }
}
