<?php

namespace Database\Factories\V1\Childcare;

use App\Models\User;
use App\Models\V1\Childcare\Ccdev;
use App\Models\V1\Childcare\PatientCcdev;
use App\Models\V1\Libraries\LibEbfReason;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Childcare>
 */
class ConsultCcdevBreastfedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'patient_ccdev_id' => fake()->randomElement(PatientCcdev::pluck('id')->toArray()),
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'bfed_month1' => fake()->boolean,
            'bfed_month2' => fake()->boolean,
            'bfed_month3' => fake()->boolean,
            'bfed_month4' => fake()->boolean,
            'bfed_month5' => fake()->boolean,
            'bfed_month6' => fake()->boolean,
            'reason_id' => fake()->randomElement(LibEbfReason::pluck('reason_id')->toArray()),
            'ebf_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
        ];
    }
}
