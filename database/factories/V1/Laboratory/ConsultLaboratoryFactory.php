<?php

namespace Database\Factories\V1\Laboratory;

use App\Models\User;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Libraries\LibLaboratory;
use App\Models\V1\Libraries\LibLaboratoryRecommendation;
use App\Models\V1\Libraries\LibLaboratoryRequestStatus;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Laboratory\ConsultLaboratory>
 */
class ConsultLaboratoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        Patient::factory()->create();

        return [
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'consult_id' => fake()->randomElement(Consult::pluck('id')->toArray()),
            'request_date' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d'),
            'lab_code' => fake()->randomElement(LibLaboratory::whereLabActive(1)->pluck('code')->toArray()),
            'recommendation_code' => fake()->randomElement(LibLaboratoryRecommendation::pluck('code')->toArray()),
            'request_status_code' => fake()->randomElement(LibLaboratoryRequestStatus::pluck('code')->toArray()),
        ];
    }
}
