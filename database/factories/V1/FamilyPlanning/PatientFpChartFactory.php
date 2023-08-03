<?php

namespace Database\Factories\V1\FamilyPlanning;

use App\Models\User;
use App\Models\V1\FamilyPlanning\PatientFp;
use App\Models\V1\FamilyPlanning\PatientFpMethod;
use App\Models\V1\Libraries\LibFpClientType;
use App\Models\V1\Libraries\LibFpDropoutReason;
use App\Models\V1\Libraries\LibFpMethod;
use App\Models\V1\Libraries\LibFpSourceSupply;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\FamilyPlanning\PatientFpChart>
 */
class PatientFpChartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_fp_id' => fake()->randomElement(PatientFp::pluck('id')->toArray()),
            'patient_fp_method_id' => fake()->randomElement(PatientFpMethod::pluck('id')->toArray()),
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'source_supply_code' => fake()->randomElement(LibFpSourceSupply::pluck('code')->toArray()),
            'service_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
        ];
    }
}
