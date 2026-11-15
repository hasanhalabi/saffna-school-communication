<?php

namespace Tests\Feature;

use App\Business\Authorization\SaffnaAccountStatus;
use App\Business\Authorization\SaffnaPermission;
use App\Business\Authorization\SaffnaPermissionMatrix;
use App\Business\Authorization\SaffnaUserGroupCode;
use App\Models\User;
use App\Policies\SaffnaUserPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class SaffnaAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_fixed_permission_matrix_matches_every_approved_group(): void
    {
        $matrix = app(SaffnaPermissionMatrix::class);

        $expectedCounts = [
            SaffnaUserGroupCode::SuperAdmin->value => 11,
            SaffnaUserGroupCode::AdminUser->value => 7,
            SaffnaUserGroupCode::Teacher->value => 3,
            SaffnaUserGroupCode::Parent->value => 3,
            SaffnaUserGroupCode::Student->value => 3,
        ];

        foreach (SaffnaUserGroupCode::cases() as $group) {
            $user = $this->user($group);
            $this->assertCount($expectedCounts[$group->value], $matrix->permissionsFor($user));
        }
    }

    public function test_super_admin_authority_is_explicit_and_unknown_actions_are_denied(): void
    {
        $superAdmin = $this->user(SaffnaUserGroupCode::SuperAdmin);
        $member = $this->user(SaffnaUserGroupCode::Teacher);

        $this->assertTrue(Gate::forUser($superAdmin)->allows('create', User::class));
        $this->assertTrue(Gate::forUser($superAdmin)->allows('update', $member));
        $this->assertFalse(Gate::forUser($superAdmin)->allows('impersonate', $member));
        $this->assertFalse(Gate::forUser($superAdmin)->allows('delete', $member));
        $this->assertFalse(Gate::forUser($superAdmin)->allows('unlisted-action', $member));
        $this->assertDatabaseHas('audit_records', [
            'actor_user_id' => $superAdmin->getKey(),
            'event' => 'authorization.denied',
        ]);
    }

    public function test_admin_users_manage_members_but_not_accounts_or_groups_of_administrators(): void
    {
        $admin = $this->user(SaffnaUserGroupCode::AdminUser);
        $teacher = $this->user(SaffnaUserGroupCode::Teacher);
        $otherAdmin = $this->user(SaffnaUserGroupCode::AdminUser);

        $this->assertTrue(Gate::forUser($admin)->allows('view', $teacher));
        $this->assertTrue(Gate::forUser($admin)->allows('update', $teacher));
        $this->assertTrue(Gate::forUser($admin)->allows('resetCredentials', $teacher));
        $this->assertFalse(Gate::forUser($admin)->allows('create', User::class));
        $this->assertFalse(Gate::forUser($admin)->allows('view', $otherAdmin));
        $this->assertFalse(Gate::forUser($admin)->allows('changeGroup', $teacher));
    }

    public function test_members_have_only_own_account_permissions(): void
    {
        $teacher = $this->user(SaffnaUserGroupCode::Teacher);
        $student = $this->user(SaffnaUserGroupCode::Student);

        $this->assertTrue(Gate::forUser($teacher)->allows('view', $teacher));
        $this->assertTrue(Gate::forUser($teacher)->allows(SaffnaPermission::ChangeOwnPassword->value));
        $this->assertFalse(Gate::forUser($teacher)->allows('view', $student));
        $this->assertFalse(Gate::forUser($teacher)->allows('update', $student));
    }

    public function test_disabled_users_receive_no_permissions(): void
    {
        $user = $this->user(SaffnaUserGroupCode::SuperAdmin);
        $user->forceFill(['status' => SaffnaAccountStatus::Disabled])->save();

        $this->assertSame([], app(SaffnaPermissionMatrix::class)->permissionsFor($user));
        $this->assertFalse(Gate::forUser($user)->allows('create', User::class));
    }

    public function test_the_final_active_super_admin_cannot_be_disabled_or_demoted(): void
    {
        $superAdmin = $this->user(SaffnaUserGroupCode::SuperAdmin);
        $secondSuperAdmin = $this->user(SaffnaUserGroupCode::SuperAdmin);

        $this->assertTrue(Gate::forUser($superAdmin)->allows('changeStatus', $secondSuperAdmin));
        $this->assertTrue(Gate::forUser($superAdmin)->allows('changeGroup', $secondSuperAdmin));

        $superAdmin->forceFill(['status' => SaffnaAccountStatus::Disabled])->save();
        $externalActor = User::factory()->make([
            'user_group_id' => $secondSuperAdmin->user_group_id,
            'status' => SaffnaAccountStatus::Active,
        ]);
        $externalActor->setRelation('userGroup', $secondSuperAdmin->userGroup);
        $policy = app(SaffnaUserPolicy::class);

        $this->assertFalse($policy->changeStatus($externalActor, $secondSuperAdmin));
        $this->assertFalse($policy->changeGroup($externalActor, $secondSuperAdmin));
    }

    private function user(SaffnaUserGroupCode $group): User
    {
        return User::factory()->inGroup($group)->create();
    }
}
