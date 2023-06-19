<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use App\Models\Api;
use App\Models\APIMethod;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class APIMethodControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function testIndex()
    {
        $api = Api::factory()->create();
        APIMethod::factory()->count(3)->create(['api_id' => $api->id]);
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson("/api/apis/{$api->id}/methods");
        $response->assertStatus(200)->assertJson(['message' => 'API methods retrieved successfully']);
    }

    public function testStore()
    {
        $api = Api::factory()->create();
        $methodData = [
            'name' => 'TestMethod',
            'url' => 'http://example.com/test',
            'documentation' => 'This is a test method',
        ];
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson("/api/apis/{$api->id}/methods", $methodData);
        $response->assertStatus(201)->assertJson(['message' => 'API method created successfully']);
    }

    public function testShow()
    {
        $api = Api::factory()->create();
        $method = APIMethod::factory()->create(['api_id' => $api->id]);
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson("/api/apis/{$api->id}/methods/{$method->id}");
        $response->assertStatus(200)->assertJson(['message' => 'API method retrieved successfully']);
    }

    public function testUpdate()
    {
        $api = Api::factory()->create();
        $method = APIMethod::factory()->create(['api_id' => $api->id]);
        $updatedMethodData = [
            'name' => 'UpdatedMethod',
            'url' => 'http://example.com/updated',
            'documentation' => 'This method has been updated',
        ];
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->putJson("/api/apis/{$api->id}/methods/{$method->id}", $updatedMethodData);
        $response->assertStatus(200)->assertJson(['message' => 'API method updated successfully']);
    }

    public function testDestroy()
    {
        $api = Api::factory()->create();
        $method = APIMethod::factory()->create(['api_id' => $api->id]);
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->deleteJson("/api/apis/{$api->id}/methods/{$method->id}");
        $response->assertStatus(200)->assertJson(['message' => 'API method deleted successfully']);
    }
}
