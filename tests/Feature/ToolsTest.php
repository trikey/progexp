<?php

namespace Tests\Feature;

use App\Tool;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ToolsTest extends TestCase
{
    use RefreshDatabase;
    private $headers;

    public function setUp()
    {
        parent::setUp();
        $user = User::create([
            'email' => 'test@gmail.com',
            'password' => bcrypt('secret1234')
        ]);
        $token = JWTAuth::fromUser($user);
        $this->headers = [
            'Accept' => 'application/json',
            'Authorization' => "Bearer {$token}",
        ];
    }

    /**
     * @group tools
     */
    public function testCreateSuccess()
    {
        $response = $this->json('POST', route('api.tools.store'), [
            'name' => 'php',
        ], $this->headers);
        $this->assertDatabaseHas('tools', ['name' => 'php']);
        $response->assertJson(['name' => 'php']);
        $response->assertStatus(200);
    }

    /**
     * @group tools
     */
    public function testCreateFail()
    {
        $response = $this->json('POST', route('api.tools.store'), [], $this->headers);
        $this->assertDatabaseMissing('tools', ['name' => 'php']);
        $response->assertJsonStructure(['message', 'errors' => ['name']]);
        $response->assertStatus(422);
    }

    /**
     * @group tools
     */
    public function testCreateFailUnique()
    {
        Tool::create(['name' => 'php']);
        $response = $this->json('POST', route('api.tools.store'), [
            'name' => 'php',
        ], $this->headers);
        $response->assertJsonStructure(['message', 'errors' => ['name']]);
        $response->assertStatus(422);

        $tools = Tool::where('name', 'php')->pluck('name');
        $this->assertCount(1, $tools);
    }

    /**
     * @group tools
     */
    public function testGetListSuccess()
    {
        $data = collect([
            ['name' => 'php'],
            ['name' => 'mysql'],
            ['name' => 'jquery']
        ]);

        $data->each(function ($item) {
            Tool::create($item);
        });

        $response = $this->json('GET', route('api.tools.index'), [], $this->headers);
        $response->assertJson($data->toArray());
        $response->assertStatus(200);
    }

    /**
     * @group tools
     */
    public function testGetItemSuccess()
    {
        $tool = Tool::create(['name' => 'php']);
        $response = $this->json('GET', route('api.tools.show', ['tool' => $tool->id]), [], $this->headers);
        $response->assertJson($tool->toArray());
        $response->assertStatus(200);
    }

    /**
     * @group tools
     */
    public function testGetItemFail()
    {
        $response = $this->json('GET', route('api.tools.show', ['tool' => 1]), [], $this->headers);
        $response->assertStatus(404);
    }

    /**
     * @group tools
     */
    public function testItemDestroySuccess()
    {
        $tool = Tool::create(['name' => 'php']);
        $response = $this->json('DELETE', route('api.tools.destroy', ['tool' => $tool->id]), [], $this->headers);
        $response->assertStatus(200);
    }

    /**
     * @group tools
     */
    public function testItemDestroyFail()
    {
        $response = $this->json('DELETE', route('api.tools.destroy', ['tool' => 1]), [], $this->headers);
        $response->assertStatus(404);
    }

    /**
     * @group tools
     */
    public function testItemUpdateSuccess()
    {
        $tool = Tool::create(['name' => 'php']);
        $response = $this->json('PUT', route('api.tools.update', ['tool' => $tool->id]), ['name' => 'sql'], $this->headers);
        $response->assertJson(['name' => 'sql', 'id' => $tool->id]);
        $response->assertStatus(200);
    }

    /**
     * @group tools
     */
    public function testItemUpdateFail()
    {
        $response = $this->json('PUT', route('api.tools.update', ['tool' => 1]), ['name' => 'sql'], $this->headers);
        $response->assertStatus(404);
    }

    /**
     * @group tools
     */
    public function testItemUpdateEmptyNameFail()
    {
        $tool = Tool::create(['name' => 'php']);
        $response = $this->json('PUT', route('api.tools.update', ['tool' => $tool->id]), ['name' => ''], $this->headers);
        $response->assertJsonStructure(['message', 'errors' => ['name']]);
        $response->assertStatus(422);
    }

    /**
     * @group tools
     */
    public function testItemUpdateUniqueFail()
    {
        $tool = Tool::create(['name' => 'php']);
        Tool::create(['name' => 'sql']);
        $response = $this->json('PUT', route('api.tools.update', ['tool' => $tool->id]), ['name' => 'sql'], $this->headers);
        $response->assertJsonStructure(['message', 'errors' => ['name']]);
        $response->assertStatus(422);
    }
}
