<?php

namespace Database\Factories\V1\Laboratory;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratory;
use App\Models\V1\Libraries\LibLaboratoryMtbResult;
use App\Models\V1\Libraries\LibLaboratoryRifResult;
use App\Models\V1\Libraries\LibLaboratoryStatus;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;
use Laravel\Passport\Passport;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Laboratory\ConsultLaboratoryGeneXpert>
 */
class ConsultLaboratoryGeneXpertFactory extends Factory
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
        $consult = ConsultLaboratory::factory()->create(['lab_code' => 'GXPT']);

        return [
            'facility_code' => $consult->facility_code,
            'user_id' => $consult->user_id,
            'patient_id' => $consult->patient_id,
            'consult_id' => $consult->consult_id,
            'laboratory_date' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d'),
            'referral_facility' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'request_id' => $consult->id,

            'collection_date' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d'),
            'release_date' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d'),
            'mtb' => fake()->randomElement(LibLaboratoryMtbResult::pluck('code')->toArray()),
            'rif' => fake()->randomElement(LibLaboratoryRifResult::pluck('code')->toArray()),
            'specimen_code' => fake()->text(20),

            'remarks' => fake()->sentence(),
            'lab_status_code' => fake()->randomElement(LibLaboratoryStatus::pluck('code')->toArray()),
        ];
    }
}
