<?php

namespace App\Business\Authorization;

enum SaffnaUserGroupCode: string
{
    case SuperAdmin = 'super_admin';
    case AdminUser = 'admin_user';
    case Teacher = 'teacher';
    case Parent = 'parent';
    case Student = 'student';
}
