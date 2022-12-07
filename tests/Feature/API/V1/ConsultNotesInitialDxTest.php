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
        $response = $this->post('api/v1/consultation/cn-idx', [
            'notes_id' => fake()->randomElement(ConsultNotes::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            "idx" => [
                [
                    "class_id" => fake()->randomElement(LibDiagnosis::pluck('class_id')->toArray()),
                    "idx_remark" => fake()->sentence(),
                ],
                [
                    "class_id" => fake()->randomElement(LibDiagnosis::pluck('class_id')->toArray()),
                    "idx_remark" => fake()->sentence(),
                ],
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
        $response = $this->delete('api/v1/consultation/cn-idx/'. $idx->id);
        $response->assertOk();
    }
}
