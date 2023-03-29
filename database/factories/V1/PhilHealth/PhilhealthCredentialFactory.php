<?php

namespace Database\Factories\V1\PhilHealth;

use App\Models\User;
use App\Models\V1\Libraries\LibPhilhealthProgram;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\PhilHealth\PhilhealthCredential>
 */
class PhilhealthCredentialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $pmcc = fake()->bothify('Z#####');
        $user = User::with('facility')->whereNotNull('facility_code')->inRandomOrder()->limit(1)->first();

        return [
            'facility_code' => $user->facility_code,
            'user_id' => $user->id,
            'program_code' => fake()->randomElement(LibPhilhealthProgram::pluck('code')->toArray()),
            'facility_name' => $user->facility->facility_name,
            'accreditation_number' => fake()->bothify('P########'),
            'pmcc_number' => $pmcc,
            'software_certification_id' => 'KON-DUMMYSCERTZ'.$pmcc,
            'cipher_key' => 'PHilheaLthDuMmyciPHerKeyS',
            'username' => 'TEST',
            'password' => 'TEST',
            'token' => fake()->sha256(),
        ];
    }
}
