<?php

namespace Database\Factories\V1\GenderBasedViolence;

use App\Models\User;
use App\Models\V1\GenderBasedViolence\PatientGbvIntake;
use App\Models\V1\Libraries\LibAnswerYn;
use App\Models\V1\Libraries\LibAnswerYnx;
use App\Models\V1\Libraries\LibGbvAbusedEpisode;
use App\Models\V1\Libraries\LibGbvAbusedSite;
use App\Models\V1\Libraries\LibGbvChildBehavior;
use App\Models\V1\Libraries\LibGbvChildRelation;
use App\Models\V1\Libraries\LibGbvDisclosedType;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\GenderBasedViolence\PatientGbvInterview>
 */
class PatientGbvInterviewFactory extends Factory
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
            'patient_gbv_intake_id' => fake()->randomElement(PatientGbvIntake::pluck('id')->toArray()),
            'info_source_code' => fake()->randomElement(LibAnswerYn::pluck('id')->toArray()),
            'incident_first_datetime' => fake()->dateTime($format = 'Y-m-d H:i:s', $max = 'now'),
            'incident_first_remarks' => fake()->sentence(),
            'incident_recent_datetime' => fake()->dateTime($format = 'Y-m-d H:i:s', $max = 'now'),
            'incident_recent_remarks' => fake()->sentence(),
            'disclosed_flag' => fake()->randomElement(LibAnswerYnx::pluck('code')->toArray()),
            'disclosed_type' => fake()->randomElement(LibGbvDisclosedType::pluck('id')->toArray()),
            'abused_episode_id' => fake()->randomElement(LibGbvAbusedEpisode::pluck('id')->toArray()),
            'abused_site_id' => fake()->randomElement(LibGbvAbusedSite::pluck('id')->toArray()),
            'abused_site_remarks' => fake()->sentence(),
            'abused_site_remarks_address' => fake()->sentence(),
            'initial_disclosure' => fake()->sentence(),
            'witnessed_flag' => fake()->boolean(),
            'relation_to_child' => fake()->randomElement(LibGbvChildRelation::pluck('id')->toArray()),
            'child_behavior_id' => fake()->randomElement(LibGbvChildBehavior::pluck('id')->toArray()),
            'child_behavior_remarks' => fake()->sentence(),
            'dev_screening_remarks' => fake()->sentence(),
        ];
    }
}
