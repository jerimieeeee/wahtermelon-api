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

    public function validatedWithCasts(): array
    {
        $mcPostPartum = PatientMcPostRegistration::find(request()->post_partum_id);
        $gravidity = $mcPostPartum->gravidity;
        $parity = $mcPostPartum->parity;
        $fullTerm = $mcPostPartum->full_term;
        $preTerm = $mcPostPartum->preterm;
        $abortion = $mcPostPartum->abortion;
        $liveBirths = $mcPostPartum->livebirths;

        return array_merge($this->validated(), [
            'gravidity' => $gravidity,
            'parity' => $parity,
            'full_term' => $fullTerm,
            'preterm' => $preTerm,
            'abortion' => $abortion,
            'livebirths' => $liveBirths,
        ]);
    }

    public function rules()
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'post_partum_id' => 'required|exists:patient_mc_post_registrations,id',
            'delivery_type' => 'required|exists:lib_pregnancy_delivery_types,code',
            'induced_hypertension' => 'required|exists:lib_ncd_answer_s2,id',
            'with_family_planning' => 'required|exists:lib_ncd_answer_s2,id',
            'pregnancy_history_applicable' => 'required|exists:lib_ncd_answer_s2,id',
        ];
    }

    public function bodyParameters()
    {
        return [
            'patient_id' => [
                'description' => 'ID of patient.',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'post_partum_id' => [
                'description' => 'ID of Maternal Care Post Partum',
                'example' => fake()->randomElement(PatientMcPostRegistration::pluck('id')->toArray()),
            ],
            'delivery_type' => [
                'description' => 'Pregnancy delivery type',
                'example' => fake()->randomElement(LibPregnancyDeliveryType::pluck('id')->toArray()),
            ],
            'induced_hypertension' => [
                'description' => 'Is patient induced hypertension during pregnancy?',
                'example' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            ],
            'with_family_planning' => [
                'description' => 'Is patient with family planning?',
                'example' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            ],
            'pregnancy_history_applicable' => [
                'description' => 'Is patient pregnancy history applicable?',
                'example' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            ],
        ];
    }
}
