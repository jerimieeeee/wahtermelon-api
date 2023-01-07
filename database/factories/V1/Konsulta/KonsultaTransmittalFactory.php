<?php

namespace Database\Factories\V1\Konsulta;

use App\Models\User;
use App\Models\V1\PhilHealth\PhilhealthCredential;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\Factory;
use Laravel\Passport\Passport;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Konsulta\KonsultaTransmittal>
 */
class KonsultaTransmittalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        Passport::actingAs(
            User::factory()->create(['facility_code' => 'DOH000000000005173'])
        );
        $philhealth = PhilhealthCredential::factory()->create([
            'program_code' => 'kp',
            'facility_name' => 'TONDO FORESHORE SUPER HEALTH CENTER',
        ]);
        $prefix = 'R' . $philhealth->accreditation_number . date('Ym');
        $transmittalNumber = IdGenerator::generate(['table' => 'konsulta_transmittals', 'field' => 'transmittal_number', 'length' => 21, 'prefix' => $prefix, 'reset_on_prefix_change' => true]);
        return [
            'facility_code' => $philhealth->facility_code,
            'user_id' => $philhealth->user_id,
            'transmittal_number' => $transmittalNumber
        ];
    }
}
