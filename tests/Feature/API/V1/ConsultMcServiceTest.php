<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\MaternalCare\ConsultMcService;
use App\Models\V1\Patient\Patient;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ConsultMcServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_consult_mc_service_can_store_data()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        Patient::factory()->create();
        $service = ConsultMcService::factory()->make()->toArray();
        $response = $this->post('api/v1/maternal-care/mc-services', $service);
        $response->assertCreated();
    }
}
