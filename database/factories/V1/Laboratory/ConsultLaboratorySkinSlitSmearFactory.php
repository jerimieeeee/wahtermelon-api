<?php

namespace Database\Factories\V1\Laboratory;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratory;
use App\Models\V1\Libraries\LibLaboratoryBiopsyType;
use App\Models\V1\Libraries\LibLaboratoryStatus;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;
use Laravel\Passport\Passport;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Laboratory\ConsultLaboratorySkinSlitSmear>
 */
class ConsultLaboratorySkinSlitSmearFactory extends Factory
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
        $consult = ConsultLaboratory::factory()->create(['lab_code' => 'SSMR']);

        return [
            'facility_code' => $consult->facility_code,
            'user_id' => $consult->user_id,
            'patient_id' => $consult->patient_id,
            'consult_id' => $consult->consult_id,
            'laboratory_date' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d'),
            'referral_facility' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'request_id' => $consult->id,

            'site_slit1' => fake()->sentence(),
            'site_slit2' => fake()->sentence(),
            'site_slit3' => fake()->sentence(),
            'site_slit4' => fake()->sentence(),
            'site_slit5' => fake()->sentence(),
            'site_slit6' => fake()->sentence(),

            'bac_index1' => fake()->sentence(),
            'bac_index2' => fake()->sentence(),
            'bac_index3' => fake()->sentence(),
            'bac_index4' => fake()->sentence(),
            'bac_index5' => fake()->sentence(),
            'bac_index6' => fake()->sentence(),

            'morp_index1' => fake()->sentence(),
            'morp_index2' => fake()->sentence(),
            'morp_index3' => fake()->sentence(),
            'morp_index4' => fake()->sentence(),
            'morp_index5' => fake()->sentence(),
            'morp_index6' => fake()->sentence(),

            'comment1' => fake()->sentence(),
            'comment2' => fake()->sentence(),
            'comment3' => fake()->sentence(),
            'comment4' => fake()->sentence(),
            'comment5' => fake()->sentence(),
            'comment6' => fake()->sentence(),

            'avg_bac_index' => fake()->numberBetween(1, 10),
            'avg_morp_index' => fake()->numberBetween(1, 10),

            'final_comment' => fake()->sentence(),

            'remarks' => fake()->sentence(),
            'lab_status_code' => fake()->randomElement(LibLaboratoryStatus::pluck('code')->toArray()),
        ];
    }
}
