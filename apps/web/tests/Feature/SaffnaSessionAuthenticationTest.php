<?php

namespace Tests\Feature;

use App\Business\Authorization\SaffnaAccountStatus;
use App\Business\Authorization\SaffnaUserGroupCode;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class SaffnaSessionAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    private const PASSWORD = 'ValidPassword123';

    public function test_valid_credentials_create_a_session_and_logout_invalidates_it(): void
    {
        $user = $this->user();

        $this->postJson('/login', [
            'email' => strtoupper($user->email),
            'password' => self::PASSWORD,
            'remember' => true,
        ])->assertOk()
            ->assertHeader('X-CSRF-TOKEN')
            ->assertJsonPath('data.authenticated', true);

        $this->assertAuthenticatedAs($user);

        $this->postJson('/logout')
            ->assertOk()
            ->assertHeader('X-CSRF-TOKEN')
            ->assertJsonPath('data.authenticated', false);

        $this->assertGuest();
    }

    public function test_invalid_and_disabled_accounts_receive_the_same_safe_error(): void
    {
        $active = $this->user(['email' => 'active@example.test']);
        $disabled = $this->user([
            'email' => 'disabled@example.test',
            'status' => SaffnaAccountStatus::Disabled,
        ]);

        $invalid = $this->postJson('/login', [
            'email' => $active->email,
            'password' => 'WrongPassword123',
        ]);
        $disabledResponse = $this->postJson('/login', [
            'email' => $disabled->email,
            'password' => self::PASSWORD,
        ]);

        $invalid->assertUnprocessable()->assertJsonPath('code', 'invalid_credentials');
        $disabledResponse->assertUnprocessable()->assertJsonPath('code', 'invalid_credentials');
        $this->assertSame($invalid->json('message'), $disabledResponse->json('message'));
        $this->assertGuest();
    }

    public function test_an_existing_session_is_revoked_after_the_account_is_disabled(): void
    {
        $user = $this->user();
        $this->actingAs($user);

        $user->forceFill(['status' => SaffnaAccountStatus::Disabled])->save();

        $this->getJson('/api/v1/me')
            ->assertUnauthorized()
            ->assertHeader('X-CSRF-TOKEN')
            ->assertJsonPath('code', 'unauthenticated');

        $this->assertGuest();
    }

    public function test_login_is_limited_to_five_attempts_per_minute(): void
    {
        $email = 'limited@example.test';
        $key = $email.'|127.0.0.1';
        RateLimiter::clear($key);

        for ($attempt = 1; $attempt <= 5; $attempt++) {
            $this->postJson('/login', [
                'email' => $email,
                'password' => 'WrongPassword123',
            ])->assertUnprocessable();
        }

        $this->postJson('/login', [
            'email' => $email,
            'password' => 'WrongPassword123',
        ])->assertTooManyRequests()->assertJsonPath('code', 'login_throttled');
    }

    private function user(array $attributes = []): User
    {
        return User::factory()
            ->inGroup(SaffnaUserGroupCode::Student)
            ->create(array_merge([
                'password' => self::PASSWORD,
                'status' => SaffnaAccountStatus::Active,
            ], $attributes));
    }
}
