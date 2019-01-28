<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
    }

    public function testLoginSuccess()
    {
        User::create([
            'email' => 'test@gmail.com',
            'password' => bcrypt('secret1234')
        ]);
        //attempt login
        $response = $this->json('POST', route('api.login'), [
            'email' => 'test@gmail.com',
            'password' => 'secret1234',
        ]);
        //Assert it was successful and a token was received
        $response->assertStatus(200);
        $response->assertHeader('authorization');
    }

    public function testLoginFail()
    {
        User::create([
            'email' => 'test@gmail.com',
            'password' => bcrypt('secret1234')
        ]);
        //attempt login
        $response = $this->json('POST', route('api.login'), [
            'email' => '',
            'password' => '',
        ]);
        $response->assertStatus(401);
        $response->assertJson(['error' => 'user_not_found']);
    }

    public function testLogoutSuccess()
    {
        $user = User::create([
            'email' => 'test@gmail.com',
            'password' => bcrypt('secret1234')
        ]);
        $token = JWTAuth::fromUser($user);

        $response = $this->json('POST', route('api.logout'), [], ['Authorization' => "Bearer {$token}"]);
        $response->assertStatus(200);
    }

    public function testLogoutFail()
    {
        $response = $this->json('POST', route('api.logout'));
        $response->assertStatus(401);
        $response->assertJson(['error' => 'unauthorized']);
    }

    public function testRefreshTokenSuccess()
    {
        $user = User::create([
            'email' => 'test@gmail.com',
            'password' => bcrypt('secret1234')
        ]);
        $token = JWTAuth::fromUser($user);
        $response = $this->json('GET', route('api.refresh'), [], ['Authorization' => "Bearer {$token}"]);
        $response->assertStatus(200);
        $response->assertHeader('authorization');
    }

    public function testRefreshTokenFail()
    {
        $response = $this->json('GET', route('api.refresh'), [], [
            'Authorization' => 'Bearer 1234',
            'Accept' => 'application/json'
        ]);
        $response->assertStatus(500);
        $response->assertJsonStructure(['message']);
    }

    public function testRegisterSuccess()
    {
        $response = $this->json('POST', route('api.register'), [
            'email' => 'test@test.ru',
            'password' => 'asdasd',
            'password_confirmation' => 'asdasd',
        ], [
            'Accept' => 'application/json'
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['email' => 'test@test.ru']);
    }

    public function testRegisterFail()
    {
        $response = $this->json('POST', route('api.register'), [
            'email' => 'test@test.ru',
            'password' => 'asddfasd',
            'password_confirmation' => 'asdasd',
        ], [
            'Accept' => 'application/json'
        ]);
        $response->assertStatus(422);
        $this->assertDatabaseMissing('users', ['email' => 'test@test.ru']);
    }
}
