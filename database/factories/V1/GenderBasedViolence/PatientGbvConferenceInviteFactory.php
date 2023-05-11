<?php

namespace Database\Factories\V1\GenderBasedViolence;

use App\Models\User;
use App\Models\V1\GenderBasedViolence\PatientGbvConference;
use App\Models\V1\Libraries\LibGbvConferenceInvitee;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\GenderBasedViolence\PatientGbvConferenceInvite>
 */
class PatientGbvConferenceInviteFactory extends Factory
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
            'patient_gbv_conference_id' => fake()->randomElement(PatientGbvConference::pluck('id')->toArray()),
            'invite_code' => fake()->randomElement(LibGbvConferenceInvitee::pluck('id')->toArray()),
            'invite_remarks' => fake()->sentence(),
        ];
    }
}
