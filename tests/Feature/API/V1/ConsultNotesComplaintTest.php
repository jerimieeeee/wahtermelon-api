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
        Consult::factory()->create(['pt_group' => 'cn', 'patient_id' => $patient->id])->consult_notes()->create(['patient_id' => $patient->id]);

        $complaint = ConsultNotesComplaint::factory()->make()->toArray();
        $response = $this->post('api/v1/consultation/cn-complaint', $complaint);
        $response->assertCreated();
    }
}
