<?php

namespace Database\Factories\V1\TBDots;

use App\Models\User;
use App\Models\V1\Libraries\LibTbPatientSource;
use App\Models\V1\Libraries\LibTbPreviousTbTreatment;
use App\Models\V1\Libraries\LibTbRegGroup;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use App\Models\V1\TBDots\PatientTb;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\TBDots\PatientTbCaseFinding>
 */
class PatientTbCaseFindingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'patient_tb_id' => fake()->randomElement(PatientTb::pluck('id')->toArray()),
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'source_code' => fake()->randomElement(LibTbPatientSource::pluck('code')->toArray()),
            'reg_group_code' => fake()->randomElement(LibTbRegGroup::pluck('code')->toArray()),
            'previous_tb_treatment_code' => fake()->randomElement(LibTbPreviousTbTreatment::pluck('code')->toArray()),
            'exposetb_flag' => fake()->boolean,
            'drtb_flag' => fake()->boolean,
            'risk_factor1' => fake()->boolean,
            'risk_factor2' => fake()->boolean,
            'risk_factor3' => fake()->boolean,
            'consult_date' => fake()->date($format =  'Y-m-d', $max = 'now')
        ];
    }
}
