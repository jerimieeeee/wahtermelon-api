<?php

namespace Database\Factories\V1\MaternalCare;

use App\Models\User;
use App\Models\V1\Libraries\LibMcRiskFactor;
use App\Models\V1\MaternalCare\PatientMc;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\MaternalCare\ConsultMcRisk>
 */
class ConsultMcRiskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $mcId = PatientMc::whereHas('preRegister')->inRandomOrder()->limit(1)->first();

        return [
            'patient_mc_id' => $mcId->id,
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'patient_id' => $mcId->patient_id,
            'risk_id' => fake()->randomElement(LibMcRiskFactor::pluck('id')->toArray()),
            'date_detected' => fake()->dateTimeInInterval('-'.fake()->numberBetween(1, 7).' week')->format('Y-m-d'),
        ];
    }
}
