<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Consultation\ConsultNotes;
use App\Models\V1\Consultation\ConsultNotesFinalDx;
use App\Models\V1\Libraries\LibIcd10;
use App\Models\V1\Patient\Patient;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ConsultNotesFinalDxTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_consultation_final_dx_can_be_created()
    {
        Passport::actingAs(
            User::factory()->create()
        );

        $response = $this->post('api/v1/consultation/final-diagnosis', [
            'notes_id' => fake()->randomElement(ConsultNotes::pluck('id')->toArray()),
            "final_diagnosis" => [
                fake()->randomElement(LibIcd10::pluck('icd10_code')->toArray()),
                fake()->randomElement(LibIcd10::pluck('icd10_code')->toArray()),
                fake()->randomElement(LibIcd10::pluck('icd10_code')->toArray())
            ]
        ]);

        $response->assertCreated();
    }

    public function test_consultation_final_dx_can_be_deleted()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $fdx = ConsultNotesFinalDx::factory()->create();
        $response = $this->delete('api/v1/consultation/final-diagnosis/'. $fdx->id);
        $response->assertOk();
    }
}
