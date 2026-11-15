<?php

namespace App\Business\Authorization;

enum SaffnaPermission: string
{
    case ViewOwnAccount = 'account.view-own';
    case ChangeOwnPassword = 'account.change-own-password';
    case ChangeOwnLanguage = 'account.change-own-language';
    case ViewAdministratorAccounts = 'users.view-administrators';
    case ViewMemberAccounts = 'users.view-members';
    case CreateAccount = 'users.create';
    case ChangeUserGroup = 'users.change-group';
    case EditMemberAccount = 'users.edit-members';
    case ResetMemberCredentials = 'users.reset-member-credentials';
    case ChangeMemberStatus = 'users.change-member-status';
    case ManageAdministratorAccount = 'users.manage-administrators';
}
