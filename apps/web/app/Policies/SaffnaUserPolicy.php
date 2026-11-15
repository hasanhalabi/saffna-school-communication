<?php

namespace App\Policies;

use App\Business\Authorization\SaffnaPermission;
use App\Business\Authorization\SaffnaPermissionMatrix;
use App\Business\Authorization\SaffnaUserGroupCode;
use App\Models\User;

class SaffnaUserPolicy
{
    public function __construct(private readonly SaffnaPermissionMatrix $permissions) {}

    public function viewAny(User $actor): bool
    {
        return $this->permissions->allows($actor, SaffnaPermission::ViewAdministratorAccounts)
            || $this->permissions->allows($actor, SaffnaPermission::ViewMemberAccounts);
    }

    public function view(User $actor, User $subject): bool
    {
        if ($actor->is($subject)) {
            return $this->permissions->allows($actor, SaffnaPermission::ViewOwnAccount);
        }

        if ($this->isAdministrator($subject)) {
            return $this->permissions->allows($actor, SaffnaPermission::ViewAdministratorAccounts);
        }

        return $this->permissions->allows($actor, SaffnaPermission::ViewMemberAccounts);
    }

    public function create(User $actor): bool
    {
        return $this->permissions->allows($actor, SaffnaPermission::CreateAccount);
    }

    public function update(User $actor, User $subject): bool
    {
        if ($actor->is($subject)) {
            return false;
        }

        if ($this->isAdministrator($subject)) {
            return $this->permissions->allows($actor, SaffnaPermission::ManageAdministratorAccount);
        }

        return $this->permissions->allows($actor, SaffnaPermission::EditMemberAccount);
    }

    public function changeGroup(User $actor, User $subject): bool
    {
        if ($actor->is($subject) || $this->isFinalActiveSuperAdmin($subject)) {
            return false;
        }

        return $this->permissions->allows($actor, SaffnaPermission::ChangeUserGroup);
    }

    public function resetCredentials(User $actor, User $subject): bool
    {
        if ($actor->is($subject)) {
            return false;
        }

        if ($this->isAdministrator($subject)) {
            return $this->permissions->allows($actor, SaffnaPermission::ManageAdministratorAccount);
        }

        return $this->permissions->allows($actor, SaffnaPermission::ResetMemberCredentials);
    }

    public function changeStatus(User $actor, User $subject): bool
    {
        if ($actor->is($subject) || $this->isFinalActiveSuperAdmin($subject)) {
            return false;
        }

        if ($this->isAdministrator($subject)) {
            return $this->permissions->allows($actor, SaffnaPermission::ManageAdministratorAccount);
        }

        return $this->permissions->allows($actor, SaffnaPermission::ChangeMemberStatus);
    }

    public function delete(User $actor, User $subject): bool
    {
        return false;
    }

    public function impersonate(User $actor, User $subject): bool
    {
        return false;
    }

    private function isAdministrator(User $user): bool
    {
        return in_array($user->groupCode(), [
            SaffnaUserGroupCode::SuperAdmin,
            SaffnaUserGroupCode::AdminUser,
        ], true);
    }

    private function isFinalActiveSuperAdmin(User $user): bool
    {
        if ($user->groupCode() !== SaffnaUserGroupCode::SuperAdmin || ! $user->isActive()) {
            return false;
        }

        return User::query()
            ->where('user_group_id', $user->user_group_id)
            ->where('status', 'active')
            ->count() <= 1;
    }
}
