<?php

namespace Database\Factories\V1\MaternalCare;

use App\Models\User;
use App\Models\V1\MaternalCare\PatientMcPreRegistration;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\MaternalCare\ConsultMcPrenatal>
 */
class ConsultMcPrenatalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $mcId = PatientMcPreRegistration::select('id', 'patient_id', 'lmp_date', 'trimester1', 'trimester2')->inRandomOrder()->first();
        $numberOfDays = $mcId->lmp_date->diff(today())->days;
        $weeks = intval(($numberOfDays)/7);
        $remainingDays = $numberOfDays % 7;
        //dd($weeks);
        return [
            'patient_mc_id' => $mcId,
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'prenatal_date' => today()->format('Y-m-d'),
            'aog_weeks' => $weeks,
            'aog_days' => $remainingDays,
            'trimester' => '1',
        ];
    }
}
