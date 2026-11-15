<?php

namespace Tests\Feature;

use App\Business\Authorization\SaffnaUserGroupCode;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class SaffnaProtectedApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_every_known_or_unknown_api_request_requires_a_session(): void
    {
        foreach (['/api/v1/me', '/api/not-a-real-route'] as $path) {
            $response = $this->getJson($path)
                ->assertUnauthorized()
                ->assertJsonPath('code', 'unauthenticated');

            $this->assertTrue(Str::isUuid($response->json('request_id')));
        }
    }

    public function test_current_user_returns_only_the_authenticated_identity_and_access_context(): void
    {
        $user = User::factory()->inGroup(SaffnaUserGroupCode::Teacher)->create([
            'name' => 'Test Teacher',
            'email' => 'teacher@example.test',
            'preferred_language' => 'en',
        ]);

        $this->actingAs($user)
            ->getJson('/api/v1/me')
            ->assertOk()
            ->assertJsonPath('data.user.name', 'Test Teacher')
            ->assertJsonPath('data.user.email', 'teacher@example.test')
            ->assertJsonPath('data.user.group', 'teacher')
            ->assertJsonPath('data.user.preferred_language', 'en')
            ->assertJsonCount(3, 'data.user.permissions')
            ->assertJsonMissingPath('data.user.password');
    }

    public function test_authenticated_unknown_api_routes_return_the_stable_not_found_error(): void
    {
        $user = User::factory()->inGroup(SaffnaUserGroupCode::Student)->create();

        $this->actingAs($user)
            ->getJson('/api/not-a-real-route')
            ->assertNotFound()
            ->assertJsonPath('code', 'not_found');
    }

    public function test_a_required_password_change_blocks_other_api_actions_but_allows_the_change_flow(): void
    {
        $user = User::factory()->inGroup(SaffnaUserGroupCode::Student)->create([
            'must_change_password' => true,
        ]);

        $this->actingAs($user)
            ->getJson('/api/v1/me')
            ->assertOk()
            ->assertJsonPath('data.user.must_change_password', true);

        $this->getJson('/api/not-a-real-route')
            ->assertStatus(409)
            ->assertJsonPath('code', 'password_change_required');

        $this->patchJson('/api/v1/account/password')
            ->assertUnprocessable()
            ->assertJsonPath('code', 'validation_failed');
    }
}
