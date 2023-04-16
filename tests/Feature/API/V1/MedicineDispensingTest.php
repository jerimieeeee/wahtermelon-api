<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Medicine\MedicineDispensing;
use App\Models\V1\Medicine\MedicinePrescription;
use Laravel\Passport\Passport;
use Tests\TestCase;

class MedicineDispensingTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_patient_philhealth_can_be_created()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        MedicinePrescription::factory()->create();
        $dispensing = MedicineDispensing::factory()->make()->toArray();
        $response = $this->post('api/v1/medicine/dispensing', $dispensing);
        $response->assertCreated();
    }
}
