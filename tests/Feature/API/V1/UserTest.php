<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Libraries\LibDesignation;
use App\Models\V1\Libraries\LibEmployer;
use App\Models\V1\PSGC\Facility;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserTest extends TestCase
{
    /*use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
        //\Artisan::call('migrate',['-vvv' => true]);
        \Artisan::call('passport:install');
        \Artisan::call('db:seed',['-vvv' => true]);
    }*/

    public function test_model_user_can_be_instantiated(): void
    {
        $user = User::factory()->create();
        $this->assertModelExists($user);
    }

    public function test_register_user_can_be_created()
    {
        $gender = fake()->randomElement(['male', 'female']);
        $response = $this->post('api/v1/register', [
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'last_name' => fake()->lastName(),
            'first_name' => fake()->firstName($gender),
            'middle_name' => fake()->lastName(),
            'suffix_name' => 'NA',
            'gender' => substr(Str::ucfirst($gender), 0, 1),
            'birthdate' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'contact_number' => fake()->phoneNumber(),
            'email' => fake()->safeEmail(),
            'designation_code' => fake()->randomElement(LibDesignation::pluck('code')->toArray()),
            'employer_code' => fake()->randomElement(LibEmployer::pluck('code')->toArray()),
            'password' => 'Password2!',
            'password_confirmation' => 'Password2!',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
        $response->assertCreated();
    }

    public function test_user_able_to_login()
    {
        $details = [
                'email' => fake()->safeEmail(),
                'password' => 'Password2!',
            ];
        User::factory()->create($details);

        $response = $this->post('api/v1/login', $details);
        $response->assertOk()
            ->assertJsonStructure(['token_type','status_code','access_token','user']);

    }

    public function test_multiple_invalid_login_attempts_are_throttled()
    {
        $details = [
            'email' => fake()->safeEmail(),
            'password' => 'Password2!',
        ];
        //User::factory()->create($details);
        for ($count = 0; $count <= 4; $count++) {
            $response = $this->post('api/v1/login', $details);
        }
        $response->assertRedirect();
    }
}
