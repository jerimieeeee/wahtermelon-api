<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Libraries\LibNcdAnswerS2;
use App\Models\V1\Libraries\LibPatientSocialHistoryAnswer;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PatientSocialHistoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_patient_social_history_can_be_created()
    {
        Passport::actingAs(
            User::factory()->create()
        );

        Patient::factory()->create()->toArray();
        $response = $this->post('api/v1/patient-social-history/history', [
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            // 'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'smoking' => fake()->randomElement(LibPatientSocialHistoryAnswer::pluck('id')->toArray()),
            'pack_per_year' => fake()->randomFloat(2, 2, 5),
            'alcohol' => fake()->randomElement(LibPatientSocialHistoryAnswer::pluck('id')->toArray()),
            'bottles_per_day' => fake()->randomFloat(2, 2, 5),
            'illicit_drugs' => fake()->randomElement(LibPatientSocialHistoryAnswer::pluck('id')->toArray()),
            'sexually_active' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
        ]);

        $response->assertCreated();
    }
}
