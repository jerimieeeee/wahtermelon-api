<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Libraries\LibMedicalHistory;
use App\Models\V1\Libraries\LibMedicalHistoryCategory;
use App\Models\V1\Patient\Patient;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PatientHistoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_patient_history_can_be_created()
    {
        Passport::actingAs(
            User::factory()->create()
        );

        Patient::factory()->create()->toArray();
        $response = $this->post('api/v1/patient-history/history', [
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'medical_history' => [
                [
                    'medical_history_id' => fake()->randomElement(LibMedicalHistory::pluck('id')->toArray()),
                    'category' => fake()->randomElement(LibMedicalHistoryCategory::pluck('id')->toArray()),
                    'remarks' => fake()->sentence(),
                ],
                [
                    'medical_history_id' => fake()->randomElement(LibMedicalHistory::pluck('id')->toArray()),
                    'category' => fake()->randomElement(LibMedicalHistoryCategory::pluck('id')->toArray()),
                    'remarks' => fake()->sentence(),
                ],
            ],
        ]);
        // dd($response);
        $response->assertCreated();
    }
}
