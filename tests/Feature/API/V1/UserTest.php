<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $user = User::factory()->make()->toArray();
        $user['password'] = 'Password2!';
        $user['password_confirmation'] = 'Password2!';

        $response = $this->post('api/v1/register', $user);
        $response->assertCreated();
    }

    public function test_user_able_to_login()
    {
        $details = [
            'email' => fake()->safeEmail(),
            'password' => 'Password2!',
            'email_verified_at' => now(),
            'is_active' => 1,
        ];
        User::factory()->create($details + []);

        $response = $this->post('api/v1/login', $details);
        $response->assertOk()
            ->assertJsonStructure(['token_type', 'status_code', 'access_token', 'user']);
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
