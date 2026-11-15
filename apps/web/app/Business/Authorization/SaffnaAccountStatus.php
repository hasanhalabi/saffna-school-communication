<?php

namespace App\Business\Authorization;

enum SaffnaAccountStatus: string
{
    case Active = 'active';
    case Disabled = 'disabled';
}
