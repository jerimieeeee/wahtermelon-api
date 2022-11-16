<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Libraries\LibVaccine;
use App\Models\V1\Libraries\LibVaccineStatus;
use App\Models\V1\Patient\Patient;
use App\Models\V1\Patient\PatientVaccine;
use Database\Seeders\LibVaccineSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PatientVaccineTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_patient_vaccine_can_be_created()
    {
        $response = $this->post('api/v1/patient-vaccines/vaccines', [
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            "vaccines" => [
                [
                    "vaccine_id" => fake()->randomElement(LibVaccine::pluck('vaccine_id')->toArray()),
                    "vaccine_date" => fake()->date($format = 'Y-m-d', $max = 'now'),
                    "status_id" => fake()->randomElement(LibVaccineStatus::pluck('status_id')->toArray()),
                ],
                [
                    "vaccine_id" => fake()->randomElement(LibVaccine::pluck('vaccine_id')->toArray()),
                    "vaccine_date" => fake()->date($format = 'Y-m-d', $max = 'now'),
                    "status_id" => fake()->randomElement(LibVaccineStatus::pluck('status_id')->toArray()),
                ],
            ]
        ]);

        $response->assertCreated();
    }

    public function test_patient_vaccine_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $patientvax = PatientVaccine::factory()->create();

        $response = $this->post('api/v1/patient-vaccines/vaccines/'. $patientvax->id, [

            'patient_id' => $patientvax->patient_id,
            'user_id' => $patientvax->user_id,
            'vaccine_id' => 'BCG',
            'vaccine_date' => '2022-01-03',
            'status_id' => '3'

        ]);
        $response->assertSessionHasNoErrors();
    }

    public function test_patient_vaccine_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $fdx = PatientVaccine::factory()->create();

        $response = $this->delete('api/v1/patient-vaccines/vaccines/'. $fdx->id, []);
        $response->assertSessionHasNoErrors();
    }
}
