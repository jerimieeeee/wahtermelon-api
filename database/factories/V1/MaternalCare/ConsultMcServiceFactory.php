<?php

namespace Database\Factories\V1\MaternalCare;

use App\Models\User;
use App\Models\V1\Libraries\LibMcService;
use App\Models\V1\Libraries\LibMcVisitType;
use App\Models\V1\MaternalCare\PatientMcPreRegistration;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\MaternalCare\ConsultMcService>
 */
class ConsultMcServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'patient_mc_id' => fake()->randomElement(PatientMcPreRegistration::pluck('patient_mc_id')->toArray()),
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'service_id' => fake()->randomElement(LibMcService::pluck('id')->toArray()),
            'visit_type_code' => fake()->randomElement(LibMcVisitType::pluck('id')->toArray()),
            'service_date' => fake()->date('Y-m-d'),
        ];
    }
}
