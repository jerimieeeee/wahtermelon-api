<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Consultation\ConsultNotes;
use App\Models\V1\Consultation\ConsultNotesInitialDx;
use App\Models\V1\Libraries\LibDiagnosis;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ConsultNotesInitialDxTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_consultation_initial_dx_can_be_created()
    {
        Passport::actingAs(
            User::factory()->create()
        );

        $response = $this->post('api/v1/consultation/initial-diagnosis', [
            'notes_id' => fake()->randomElement(ConsultNotes::pluck('id')->toArray()),
            "initial_diagnosis" => [
                fake()->randomElement(LibDiagnosis::pluck('class_id')->toArray()),
                fake()->randomElement(LibDiagnosis::pluck('class_id')->toArray()),
                fake()->randomElement(LibDiagnosis::pluck('class_id')->toArray())
            ]
        ]);

        $response->assertCreated();
    }

    public function test_consultation_initial_dx_can_be_deleted()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $idx = ConsultNotesInitialDx::factory()->create();
        $response = $this->delete('api/v1/consultation/initial-diagnosis/'. $idx->id);
        $response->assertOk();
    }
}
