<?php

namespace Database\Factories\V1\Laboratory;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratory;
use App\Models\V1\Libraries\LibLaboratoryFindings;
use App\Models\V1\Libraries\LibLaboratoryStatus;
use App\Models\V1\Patient\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;
use Laravel\Passport\Passport;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Laboratory\ConsultLaboratoryEcg>
 */
class ConsultLaboratoryEcgFactory extends Factory
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
        Patient::factory()->create();
        $consult = ConsultLaboratory::factory()->create(['lab_code' => 'ECG']);
        $findings = fake()->randomElement(LibLaboratoryFindings::pluck('code')->toArray());

        return [
            'facility_code' => $consult->facility_code,
            'user_id' => $consult->user_id,
            'patient_id' => $consult->patient_id,
            'consult_id' => $consult->consult_id,
            'laboratory_date' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d'),
            'request_id' => $consult->id,
            'findings_code' => $findings,
            'remarks' => $findings == '2' ? fake()->sentence() : null,
            'lab_status_code' => fake()->randomElement(LibLaboratoryStatus::pluck('code')->toArray()),
        ];
    }
}
