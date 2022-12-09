<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Consultation\ConsultNotes;
use App\Models\V1\Consultation\ConsultNotesComplaint;
use App\Models\V1\Libraries\LibComplaint;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ConsultNotesComplaintTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_consultation_chief_complaint_can_be_created()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        //Create Consult and Consult Notes
        $patient = Patient::factory()->create();
        Consult::factory()->create(['pt_group' => 'cn', 'patient_id' => $patient->id])->consultNotes()->create(['patient_id' => $patient->id]);


        //Create Consult Notes Complaint
        $response = $this->post('api/v1/consultation/complaint', [
            'notes_id' => fake()->randomElement(ConsultNotes::pluck('id')->toArray()),
            'consult_id' => fake()->randomElement(Consult::pluck('id')->toArray()),
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'complaints' => [
                fake()->randomElement(LibComplaint::pluck('complaint_id')->toArray()),
                fake()->randomElement(LibComplaint::pluck('complaint_id')->toArray()),
                fake()->randomElement(LibComplaint::pluck('complaint_id')->toArray())
            ]
        ]);
        $response->assertCreated();
    }
}
