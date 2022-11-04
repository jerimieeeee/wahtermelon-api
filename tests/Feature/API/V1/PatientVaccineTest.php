<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Libraries\LibVaccine;
use App\Models\V1\Libraries\LibVaccineStatus;
use App\Models\V1\Patient\Patient;
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
        $response = $this->post('api/v1/patient-vaccine', [
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'vaccines' => [fake()->randomElement(LibVaccine::pluck('vaccine_id')->toArray())],
            'vaccine_date' => [fake()->date($format = 'Y-m-d', $max = 'now')],
            'status_id' => [fake()->randomElement(LibVaccineStatus::pluck('status_id')->toArray())],
        ]);
        $response->assertCreated();
    }
}
