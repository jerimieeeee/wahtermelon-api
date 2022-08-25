<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void {
        parent::setUp();
        //\Artisan::call('migrate',['-vvv' => true]);
        \Artisan::call('passport:install');
        //\Artisan::call('db:seed',['-vvv' => true]);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_can_be_created(): void
    {
        $user = User::factory()->create();
        $this->assertModelExists($user);
    }

    public function test_register_user_can_be_created()
    {
        $gender = fake()->randomElement(['male', 'female']);
        $response = $this->post('api/v1/register', [
            'last_name' => fake()->lastName(),
            'first_name' => fake()->firstName($gender),
            'middle_name' => fake()->lastName(),
            'suffix_name' => 'NA',
            'gender' => substr(Str::ucfirst($gender), 0, 1),
            'birthdate' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'contact_number' => fake()->phoneNumber(),
            'email' => fake()->safeEmail(),
            'password' => 'Password2!',
            'password_confirmation' => 'Password2!',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
        $response->assertCreated();
    }

    public function test_user_able_to_login()
    {
        User::factory()->create([
            'email' => 'testing@testing.test',
            'password' => 'Password2!',
        ]);
        $response = $this->post('api/v1/login', [
            'email' => 'testing@testing.test',
            'password' => 'Password2!',
        ]);
        $response->assertOk();
    }
}
