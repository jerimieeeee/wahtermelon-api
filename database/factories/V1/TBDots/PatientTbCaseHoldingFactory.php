<?php

namespace Database\Factories\V1\TBDots;

use App\Models\User;
use App\Models\V1\Libraries\LibTbAnatomicalSite;
use App\Models\V1\Libraries\LibTbBacteriologicalStatus;
use App\Models\V1\Libraries\LibTbEnrollAs;
use App\Models\V1\Libraries\LibTbEptbSite;
use App\Models\V1\Libraries\LibTbIptType;
use App\Models\V1\Libraries\LibTbTreatmentRegimen;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use App\Models\V1\TBDots\PatientTb;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\TBDots\PatientTbCaseHolding>
 */
class PatientTbCaseHoldingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        Patient::factory()->create();

        return [
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'patient_tb_id' => fake()->randomElement(PatientTb::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'case_number' => fake()->regexify('[A-Za-z0-9]{20}'),
            'enroll_as_code' => fake()->randomElement(LibTbEnrollAs::pluck('code')->toArray()),
            'treatment_regimen_code' => fake()->randomElement(LibTbTreatmentRegimen::pluck('code')->toArray()),
            'registration_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'treatment_start' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'continuation_start' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'treatment_end' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'bacteriological_status_code' => fake()->randomElement(LibTbBacteriologicalStatus::pluck('code')->toArray()),
            'anatomical_site_code' => fake()->randomElement(LibTbAnatomicalSite::pluck('code')->toArray()),
            'eptb_site_id' => fake()->randomElement(LibTbEptbSite::pluck('id')->toArray()),
            'specific_site' => fake()->sentence(),
            'drug_resistant_flag' => fake()->boolean,
            'ipt_type_code' => fake()->randomElement(LibTbIptType::pluck('code')->toArray()),
            'transfer_flag' => fake()->boolean,
            'pict_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
        ];
    }
}
