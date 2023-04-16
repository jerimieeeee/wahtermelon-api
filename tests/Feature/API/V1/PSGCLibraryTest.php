<?php

namespace Tests\Feature\API\V1;

use App\Models\V1\PSGC\Barangay;
use App\Models\V1\PSGC\Facility;
use App\Models\V1\PSGC\Municipality;
use App\Models\V1\PSGC\Province;
use App\Models\V1\PSGC\Region;
use Tests\TestCase;

class PSGCLibraryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_can_view_all_regions(): void
    {
        $response = $this->get('api/v1/libraries/regions');
        $response->assertStatus(200);
    }

    public function test_can_view_specific_region(): void
    {
        $code = fake()->randomElement(Region::pluck('code')->toArray());
        $response = $this->get('api/v1/libraries/regions/'.$code);
        $response->assertStatus(200);
    }

    public function test_can_view_all_provinces(): void
    {
        $response = $this->get('api/v1/libraries/provinces');
        $response->assertStatus(200);
    }

    public function test_can_view_specific_province(): void
    {
        $code = fake()->randomElement(Province::pluck('code')->toArray());
        $response = $this->get('api/v1/libraries/provinces/'.$code);
        $response->assertStatus(200);
    }

    public function test_can_view_all_municipalities(): void
    {
        $response = $this->get('api/v1/libraries/municipalities');
        $response->assertStatus(200);
    }

    public function test_can_view_specific_municipality(): void
    {
        $code = fake()->randomElement(Municipality::pluck('code')->toArray());
        $response = $this->get('api/v1/libraries/municipalities/'.$code);
        $response->assertStatus(200);
    }

    public function test_can_view_all_barangays(): void
    {
        $response = $this->get('api/v1/libraries/barangays');
        $response->assertStatus(200);
    }

    public function test_can_view_specific_barangay(): void
    {
        $code = fake()->randomElement(Barangay::pluck('code')->toArray());
        $response = $this->get('api/v1/libraries/barangays/'.$code);
        $response->assertStatus(200);
    }

    public function test_can_view_all_facilities(): void
    {
        $response = $this->get('api/v1/libraries/facilities');
        $response->assertStatus(200);
    }

    public function test_can_view_specific_facility(): void
    {
        $code = fake()->randomElement(Facility::pluck('code')->toArray());
        $response = $this->get('api/v1/libraries/facilities/'.$code);
        $response->assertStatus(200);
    }
}
