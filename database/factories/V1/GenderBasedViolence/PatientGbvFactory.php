<?php

namespace Database\Factories\V1\GenderBasedViolence;

use App\Models\User;
use App\Models\V1\Libraries\LibGbvChildRelation;
use App\Models\V1\Libraries\LibGbvEconomicStatus;
use App\Models\V1\Libraries\LibGbvLivingArrangement;
use App\Models\V1\Libraries\LibGbvOutcomeReason;
use App\Models\V1\Libraries\LibGbvOutcomeResult;
use App\Models\V1\Libraries\LibGbvOutcomeVerdict;
use App\Models\V1\Libraries\LibGbvPrimaryComplaints;
use App\Models\V1\Libraries\LibGbvService;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Barangay;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\GenderBasedViolence\PatientGbv>
 */
class PatientGbvFactory extends Factory
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
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'case_number' => fake()->regexify('[A-Za-z0-9]{20}'),
            'case_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'outcome_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'outcome_reason_id' => fake()->randomElement(LibGbvOutcomeReason::pluck('id')->toArray()),
            'outcome_result_id' => fake()->randomElement(LibGbvOutcomeResult::pluck('id')->toArray()),
            'outcome_verdict_id' => fake()->randomElement(LibGbvOutcomeVerdict::pluck('id')->toArray()),
            'primary_complaint_id' => fake()->randomElement(LibGbvPrimaryComplaints::pluck('id')->toArray()),
            'service_id' => fake()->randomElement(LibGbvService::pluck('id')->toArray()),
            'primary_complaint_remarks' => fake()->sentence,
            'service_remarks' => fake()->sentence,
            'neglect_remarks' => fake()->sentence,
            'behavioral_remarks' => fake()->sentence,
            'economic_status_id' => fake()->randomElement(LibGbvEconomicStatus::pluck('id')->toArray()),
            'barangay_code' => fake()->randomElement(Barangay::pluck('psgc_10_digit_code')->toArray()),
            'address' => fake()->address(),
            'direction_to_address' => fake()->address(),
            'guardian_name' => fake()->name(),
            'guardian_address' => fake()->address(),
            'relation_to_child_id' => fake()->randomElement(LibGbvChildRelation::pluck('id')->toArray()),
            'guardian_contact_info' => fake()->phoneNumber(),
            'same_bed_adult_male_flag' => fake()->boolean(),
            'same_bed_adult_female_flag' => fake()->boolean(),
            'same_bed_child_male_flag' => fake()->boolean(),
            'same_bed_child_female_flag' => fake()->boolean(),
            'same_room_adult_male_flag' => fake()->boolean(),
            'same_room_adult_female_flag' => fake()->boolean(),
            'same_room_child_male_flag' => fake()->boolean(),
            'abuse_living_arrangement_id' => fake()->randomElement(LibGbvLivingArrangement::pluck('id')->toArray()),
            'present_living_arrangement_id' => fake()->randomElement(LibGbvLivingArrangement::pluck('id')->toArray()),
        ];
    }
}
