<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use App\Models\Api;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $api = Api::factory()->create();
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/apis');
        $response->assertStatus(200)->assertJson(['message' => 'APIs retrieved successfully']);
    }

    public function testStore()
    {
        $data = [
            'name' => 'Test API',
            'base_url' => 'https://testapi.com',
        ];
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)  
            ->postJson('/api/apis', $data);
        $response->assertStatus(201)
                 ->assertJson(['message' => 'API created successfully'])
                 ->assertJsonPath('data.name', $data['name'])
                 ->assertJsonPath('data.base_url', $data['base_url']);
    }

    public function testShow()
    {
        $api = Api::factory()->create();
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)  
            ->getJson("/api/apis/{$api->id}");
        $response->assertStatus(200)
                 ->assertJson(['message' => 'API retrieved successfully'])
                 ->assertJsonPath('data.name', $api->name)
                 ->assertJsonPath('data.base_url', $api->base_url);
    }

    public function testUpdate()
    {
        $api = Api::factory()->create();
        $updateData = [
            'name' => 'Updated API',
            'base_url' => 'https://updatedapi.com',
        ];
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)  
            ->putJson("/api/apis/{$api->id}", $updateData);
        $response->assertStatus(200)
                 ->assertJson(['message' => 'API updated successfully'])
                 ->assertJsonPath('data.name', $updateData['name'])
                 ->assertJsonPath('data.base_url', $updateData['base_url']);
    }

    public function testDestroy()
    {
        $api = Api::factory()->create();
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)  
            ->deleteJson("/api/apis/{$api->id}");
        $response->assertStatus(200)->assertJson(['message' => 'API deleted successfully']);
    }
}
