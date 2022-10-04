<?php

namespace Tests\Feature\API\V1;

use App\Models\V1\Libraries\LibComplaint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ComplaintLibraryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_view_all_consult_complaint()
    {
        $response = $this->get('api/v1/libraries/complaint');
        $response->assertStatus(200);
    }

    public function test_can_view_specific_consult_complaint(): void
    {
        $code = fake()->randomElement(LibComplaint::pluck('complaint_id')->toArray());
        $response = $this->get('api/v1/libraries/complaint/'.$code);
        $response->assertStatus(200);
    }
}
