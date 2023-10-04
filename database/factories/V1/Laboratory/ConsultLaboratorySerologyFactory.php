<?php

namespace Database\Factories\V1\Laboratory;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratory;
use App\Models\V1\Libraries\LibLaboratoryStatus;
use App\Models\V1\Libraries\LibLaboratoryUltrasoundType;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;
use Laravel\Passport\Passport;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Laboratory\ConsultLaboratorySerology>
 */
class ConsultLaboratorySerologyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        Passport::actingAs(
            User::factory()->create()
        );
        Patient::factory()->create();
        $consult = ConsultLaboratory::factory()->create(['lab_code' => 'SRLG']);

        return [
            'facility_code' => $consult->facility_code,
            'user_id' => $consult->user_id,
            'patient_id' => $consult->patient_id,
            'consult_id' => $consult->consult_id,
            'laboratory_date' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d'),
            'referral_facility' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'request_id' => $consult->id,

            'hiv' => fake()->words(2),
            'hcv' => fake()->words(2),
            'anti_streptolysin' => fake()->words(2),
            'reactive_protein' => fake()->words(2),
            'rheumatoid_factor' => fake()->words(2),
            'rapid_plasma' => fake()->words(2),

            'remarks' => fake()->sentence(),
            'lab_status_code' => fake()->randomElement(LibLaboratoryStatus::pluck('code')->toArray()),
        ];
    }
}
