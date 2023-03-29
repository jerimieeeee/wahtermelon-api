<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Childcare\ConsultCcdevService;
use App\Models\V1\Libraries\LibCcdevService;
use App\Models\V1\Libraries\LibVaccineStatus;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ChildcareServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_childcare_service_can_be_created()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $services = [
            'services' => [
                [
                    'service_id' => fake()->randomElement(LibCcdevService::pluck('service_id')->toArray()),
                    'service_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
                    'status_id' => fake()->randomElement(LibVaccineStatus::pluck('status_id')->toArray()),
                ],
                [
                    'service_id' => fake()->randomElement(LibCcdevService::pluck('service_id')->toArray()),
                    'service_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
                    'status_id' => fake()->randomElement(LibVaccineStatus::pluck('status_id')->toArray()),
                ],
            ],
        ];
        $consult = ConsultCcdevService::factory()->make($services)->toArray();
        $response = $this->post('api/v1/child-care/cc-services', $consult);

        $response->assertCreated();
    }
}
