<?php

namespace App\Business\Authorization;

use App\Models\User;

class SaffnaPermissionMatrix
{
    /**
     * @return list<SaffnaPermission>
     */
    public function permissionsFor(User $user): array
    {
        if (! $user->isActive()) {
            return [];
        }

        $group = $user->groupCode();

        if ($group === null) {
            return [];
        }

        return match ($group) {
            SaffnaUserGroupCode::SuperAdmin => [
                SaffnaPermission::ViewOwnAccount,
                SaffnaPermission::ChangeOwnPassword,
                SaffnaPermission::ChangeOwnLanguage,
                SaffnaPermission::ViewAdministratorAccounts,
                SaffnaPermission::ViewMemberAccounts,
                SaffnaPermission::CreateAccount,
                SaffnaPermission::ChangeUserGroup,
                SaffnaPermission::EditMemberAccount,
                SaffnaPermission::ResetMemberCredentials,
                SaffnaPermission::ChangeMemberStatus,
                SaffnaPermission::ManageAdministratorAccount,
            ],
            SaffnaUserGroupCode::AdminUser => [
                SaffnaPermission::ViewOwnAccount,
                SaffnaPermission::ChangeOwnPassword,
                SaffnaPermission::ChangeOwnLanguage,
                SaffnaPermission::ViewMemberAccounts,
                SaffnaPermission::EditMemberAccount,
                SaffnaPermission::ResetMemberCredentials,
                SaffnaPermission::ChangeMemberStatus,
            ],
            SaffnaUserGroupCode::Teacher,
            SaffnaUserGroupCode::Parent,
            SaffnaUserGroupCode::Student => [
                SaffnaPermission::ViewOwnAccount,
                SaffnaPermission::ChangeOwnPassword,
                SaffnaPermission::ChangeOwnLanguage,
            ],
        };
    }

    public function allows(User $user, SaffnaPermission $permission): bool
    {
        return in_array($permission, $this->permissionsFor($user), true);
    }

    /**
     * @return list<string>
     */
    public function permissionValuesFor(User $user): array
    {
        $values = array_map(
            static fn (SaffnaPermission $permission): string => $permission->value,
            $this->permissionsFor($user),
        );

        sort($values);

        return $values;
    }
}
