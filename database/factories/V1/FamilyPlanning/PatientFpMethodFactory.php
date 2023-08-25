<?php

namespace Database\Factories\V1\FamilyPlanning;

use App\Models\User;
use App\Models\V1\FamilyPlanning\PatientFp;
use App\Models\V1\Libraries\LibFpClientType;
use App\Models\V1\Libraries\LibFpDropoutReason;
use App\Models\V1\Libraries\LibFpHistory;
use App\Models\V1\Libraries\LibFpMethod;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\FamilyPlanning\PatientFpMethod>
 */
class PatientFpMethodFactory extends Factory
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
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'method_code' => fake()->randomElement(LibFpMethod::pluck('code')->toArray()),
            'enrollment_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'client_code' => fake()->randomElement(LibFpClientType::pluck('code')->toArray()),
            'treatment_partner' => fake()->firstName(),
            'permanent_reason' => fake()->text(),
            'dropout_flag' => fake()->boolean(),
            'dropout_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'dropout_reason_code' => fake()->randomElement(LibFpDropoutReason::pluck('code')->toArray()),
            'dropout_remarks' => fake()->text(),
        ];
    }
}
