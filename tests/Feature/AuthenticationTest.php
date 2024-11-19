<?php

namespace Tests\Feature;

use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function getRandomRegisterData()
    {
        return [
            'name' => fake()->name,
            'username' => fake()->userName,
            'email' => self::TEST_EMAIL,
            'password' => self::TEST_PASSWORD,
            'password_confirmation' => self::TEST_PASSWORD,
        ];
    }

    public function test_guest_can_register()
    {
        $data = $this->getRandomRegisterData();

        $response = $this->postJson('/api/register', $data);
        $token = $response->json('token');

        $response->assertStatus(201);
        $response->assertJsonStructure(['token', 'user']);

        $this->assertNotEmpty($token);

        $this->assertDatabaseHas('users', [
            'email' => self::TEST_EMAIL,
        ]);
    }

    public function test_user_should_receive_welcome_mail_upon_register()
    {
        Mail::fake();

        $data = $this->getRandomRegisterData();

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(201);

        Mail::assertSent(WelcomeMail::class);
    }

    public function test_user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => self::TEST_EMAIL,
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => self::TEST_PASSWORD
        ]);

        $response->assertStatus(200);
        $token = $response->json('token');

        $response->assertJsonStructure(['token']);
        $this->assertNotEmpty($token);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/user');
        $response->assertStatus(200);
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/logout');
        $response->assertStatus(204);
    }

    public function test_guest_cannot_visit_protected_routes()
    {
        $response = $this->getJson('/api/user');
        $response->assertStatus(401);
    }
}
