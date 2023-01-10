<?php

namespace Database\Factories\V1\Patient;

use App\Models\V1\Libraries\LibNcdAnswerS2;
use App\Models\V1\Libraries\LibPregnancyDeliveryType;
use App\Models\V1\MaternalCare\PatientMcPostRegistration;
use App\Models\V1\Patient\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Patient\PatientPregnancyHistory>
 */
class PatientPregnancyHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'post_partum_id' => fake()->randomElement(PatientMcPostRegistration::pluck('id')->toArray()),
            'gravidity' => fake()->randomNumber(2, true),
            'parity' => fake()->randomNumber(2, true),
            'delivery_type' => fake()->randomElement(LibPregnancyDeliveryType::pluck('code')->toArray()),
            'induced_hypertension' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            'with_family_planning' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            'pregnancy_history_applicable' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            'full_term' => fake()->randomNumber(2, true),
            'preterm' => fake()->randomNumber(2, true),
            'abortion' => fake()->randomNumber(2, true),
            'livebirths' => fake()->randomNumber(2, true),
        ];
    }
}
