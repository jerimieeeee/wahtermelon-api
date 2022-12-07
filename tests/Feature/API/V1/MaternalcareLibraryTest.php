<?php

namespace Tests\Feature\API\V1;

use App\Models\V1\Libraries\LibMcAttendant;
use App\Models\V1\Libraries\LibMcDeliveryLocation;
use App\Models\V1\Libraries\LibMcLocation;
use App\Models\V1\Libraries\LibMcOutcome;
use App\Models\V1\Libraries\LibMcPregnancyTermination;
use App\Models\V1\Libraries\LibMcPresentation;
use App\Models\V1\Libraries\LibMcRiskFactor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MaternalcareLibraryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_view_all_attendants(): void
    {
        $response = $this->get('api/v1/libraries/mc-attendants');
        $response->assertStatus(200);
    }

    public function test_can_view_specific_attendant(): void
    {
        $code = fake()->randomElement(LibMcAttendant::pluck('code')->toArray());
        $response = $this->get('api/v1/libraries/mc-attendants/'.$code);
        $response->assertStatus(200);
    }

    public function test_can_view_all_delivery_locations(): void
    {
        $response = $this->get('api/v1/libraries/mc-delivery-locations');
        $response->assertStatus(200);
    }

    public function test_can_view_specific_delivery_location(): void
    {
        $code = fake()->randomElement(LibMcDeliveryLocation::pluck('code')->toArray());
        $response = $this->get('api/v1/libraries/mc-delivery-locations/'.$code);
        $response->assertStatus(200);
    }

    public function test_can_view_all_locations(): void
    {
        $response = $this->get('api/v1/libraries/mc-locations');
        $response->assertStatus(200);
    }

    public function test_can_view_specific_location(): void
    {
        $code = fake()->randomElement(LibMcLocation::pluck('code')->toArray());
        $response = $this->get('api/v1/libraries/mc-locations/'.$code);
        $response->assertStatus(200);
    }

    public function test_can_view_all_outcomes(): void
    {
        $response = $this->get('api/v1/libraries/mc-outcomes');
        $response->assertStatus(200);
    }

    public function test_can_view_specific_outcome(): void
    {
        $code = fake()->randomElement(LibMcOutcome::pluck('code')->toArray());
        $response = $this->get('api/v1/libraries/mc-outcomes/'.$code);
        $response->assertStatus(200);
    }

    public function test_can_view_all_pregnancy_terminations(): void
    {
        $response = $this->get('api/v1/libraries/mc-pregnancy-terminations');
        $response->assertStatus(200);
    }

    public function test_can_view_specific_pregnancy_termination(): void
    {
        $code = fake()->randomElement(LibMcPregnancyTermination::pluck('code')->toArray());
        $response = $this->get('api/v1/libraries/mc-pregnancy-terminations/'.$code);
        $response->assertStatus(200);
    }

    public function test_can_view_all_presentations(): void
    {
        $response = $this->get('api/v1/libraries/mc-presentations');
        $response->assertStatus(200);
    }

    public function test_can_view_specific_presentation(): void
    {
        $code = fake()->randomElement(LibMcPresentation::pluck('code')->toArray());
        $response = $this->get('api/v1/libraries/mc-presentations/'.$code);
        $response->assertStatus(200);
    }

    public function test_can_view_all_risk_factors(): void
    {
        $response = $this->get('api/v1/libraries/mc-risk-factors');
        $response->assertStatus(200);
    }

    public function test_can_view_specific_risk_factor(): void
    {
        $id = fake()->randomElement(LibMcRiskFactor::pluck('id')->toArray());
        $response = $this->get('api/v1/libraries/mc-risk-factors/'.$id);
        $response->assertStatus(200);
    }
}
