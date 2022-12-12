<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Consultation\ConsultPeRemarks;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ConsultPeRemarksTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_consultation_physical_exam_remarks_can_be_created()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $pe_remarks = ConsultPeRemarks::factory()->make()->toArray();
        $response = $this->post('api/v1/consultation/physical-exam-remarks', $pe_remarks);
        $response->assertCreated();
    }
}
