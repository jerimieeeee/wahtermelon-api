<?php

namespace Tests\Feature\API\V1;

use App\Models\V1\Libraries\LibPe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PeLibraryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_view_all_consult_pe()
    {
        $response = $this->get('api/v1/libraries/pe');
        $response->assertStatus(200);
    }

    public function test_can_view_specific_consult_pe(): void
    {
        $code = fake()->randomElement(LibPe::pluck('pe_id')->toArray());
        $response = $this->get('api/v1/libraries/pe/'.$code);
        $response->assertStatus(200);
    }
}
