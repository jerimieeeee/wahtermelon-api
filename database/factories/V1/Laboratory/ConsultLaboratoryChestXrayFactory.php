<?php

namespace Database\Factories\V1\Laboratory;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratory;
use App\Models\V1\Libraries\LibLaboratoryChestxrayFindings;
use App\Models\V1\Libraries\LibLaboratoryChestxrayObservation;
use App\Models\V1\Libraries\LibLaboratoryStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Laravel\Passport\Passport;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Laboratory\ConsultLaboratoryChestXray>
 */
class ConsultLaboratoryChestXrayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        //$consult = ConsultLaboratory::whereLabCode('CBC')->inRandomOrder()->limit(1)->first();
        $consult = ConsultLaboratory::factory()->create(['lab_code' => 'CXRAY']);
        $findings = fake()->randomElement(LibLaboratoryChestxrayFindings::pluck('code')->toArray());
        $observation = fake()->randomElement(LibLaboratoryChestxrayObservation::pluck('code')->toArray());

        return [
            'facility_code' => $consult->facility_code,
            'user_id' => $consult->user_id,
            'patient_id' => $consult->patient_id,
            'consult_id' => $consult->consult_id,
            'laboratory_date' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d'),
            'request_id' => $consult->id,
            'findings_code' => $findings,
            'remarks_findings' => $findings == '99' ? fake()->sentence() : null,
            'observation_code' => $observation,
            'remarks_observation' => $observation == '99' ? fake()->sentence() : null,
            'remarks' => fake()->sentence(),
            'lab_status_code' => fake()->randomElement(LibLaboratoryStatus::pluck('code')->toArray()),
        ];
    }
}
