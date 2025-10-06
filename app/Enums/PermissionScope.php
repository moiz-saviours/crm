<?php

namespace App\Enums;
enum PermissionScope: string
{
    case ALL = 'all';
    case TEAM = 'team';
    case OWN = 'own';
    case BRAND = 'brand';
    case NONE = 'none';
}
