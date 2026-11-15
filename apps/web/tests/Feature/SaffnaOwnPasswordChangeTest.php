<?php

namespace Tests\Feature;

use App\Business\Authorization\SaffnaAccountStatus;
use App\Business\Authorization\SaffnaUserGroupCode;
use App\Models\SaffnaAuditRecord;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SaffnaOwnPasswordChangeTest extends TestCase
{
    use RefreshDatabase;

    private const CURRENT_PASSWORD = 'TemporaryPassword123';

    private const NEW_PASSWORD = 'ReplacementPassword456';

    public function test_a_required_password_change_updates_the_password_clears_the_flag_and_is_audited(): void
    {
        $user = $this->user(['must_change_password' => true]);

        $this->actingAs($user)
            ->patchJson('/api/v1/account/password', [
                'current_password' => self::CURRENT_PASSWORD,
                'password' => self::NEW_PASSWORD,
                'password_confirmation' => self::NEW_PASSWORD,
            ])
            ->assertOk()
            ->assertHeader('X-CSRF-TOKEN')
            ->assertJsonPath('data.password_changed', true)
            ->assertJsonPath('data.must_change_password', false);

        $user->refresh();

        $this->assertFalse($user->must_change_password);
        $this->assertTrue(Hash::check(self::NEW_PASSWORD, $user->password));
        $this->assertAuthenticatedAs($user);
        $this->assertDatabaseHas(SaffnaAuditRecord::class, [
            'actor_user_id' => $user->getKey(),
            'subject_user_id' => $user->getKey(),
            'event' => 'account.password.changed',
        ]);
    }

    public function test_the_current_password_must_be_correct(): void
    {
        $user = $this->user(['must_change_password' => true]);

        $this->actingAs($user)
            ->patchJson('/api/v1/account/password', [
                'current_password' => 'IncorrectPassword123',
                'password' => self::NEW_PASSWORD,
                'password_confirmation' => self::NEW_PASSWORD,
            ])
            ->assertUnprocessable()
            ->assertJsonPath('code', 'validation_failed')
            ->assertJsonValidationErrors('current_password');

        $user->refresh();
        $this->assertTrue($user->must_change_password);
        $this->assertTrue(Hash::check(self::CURRENT_PASSWORD, $user->password));
        $this->assertDatabaseMissing(SaffnaAuditRecord::class, [
            'event' => 'account.password.changed',
        ]);
    }

    public function test_password_validation_messages_follow_the_requested_language(): void
    {
        $user = $this->user(['must_change_password' => true]);

        $this->actingAs($user)
            ->withHeader('Accept-Language', 'en')
            ->patchJson('/api/v1/account/password', [
                'current_password' => 'IncorrectPassword123',
                'password' => self::NEW_PASSWORD,
                'password_confirmation' => self::NEW_PASSWORD,
            ])
            ->assertUnprocessable()
            ->assertJsonPath('errors.current_password.0', 'The current password is incorrect.');
    }

    public function test_the_new_password_must_meet_policy_differ_and_match_confirmation(): void
    {
        $user = $this->user(['must_change_password' => true]);
        $this->actingAs($user);

        $this->patchJson('/api/v1/account/password', [
            'current_password' => self::CURRENT_PASSWORD,
            'password' => 'weakpassword',
            'password_confirmation' => 'weakpassword',
        ])->assertUnprocessable()->assertJsonValidationErrors('password');

        $this->patchJson('/api/v1/account/password', [
            'current_password' => self::CURRENT_PASSWORD,
            'password' => self::CURRENT_PASSWORD,
            'password_confirmation' => self::CURRENT_PASSWORD,
        ])->assertUnprocessable()->assertJsonValidationErrors('password');

        $this->patchJson('/api/v1/account/password', [
            'current_password' => self::CURRENT_PASSWORD,
            'password' => self::NEW_PASSWORD,
            'password_confirmation' => 'DifferentPassword789',
        ])->assertUnprocessable()->assertJsonValidationErrors('password');

        $user->refresh();
        $this->assertTrue($user->must_change_password);
        $this->assertTrue(Hash::check(self::CURRENT_PASSWORD, $user->password));
    }

    public function test_a_non_required_user_can_change_their_own_password(): void
    {
        $user = $this->user(['must_change_password' => false]);

        $this->actingAs($user)
            ->patchJson('/api/v1/account/password', [
                'current_password' => self::CURRENT_PASSWORD,
                'password' => self::NEW_PASSWORD,
                'password_confirmation' => self::NEW_PASSWORD,
            ])
            ->assertOk();

        $this->assertTrue(Hash::check(self::NEW_PASSWORD, $user->fresh()->password));
    }

    private function user(array $attributes = []): User
    {
        return User::factory()
            ->inGroup(SaffnaUserGroupCode::Student)
            ->create(array_merge([
                'password' => self::CURRENT_PASSWORD,
                'status' => SaffnaAccountStatus::Active,
            ], $attributes));
    }
}
