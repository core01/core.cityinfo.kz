<?php

namespace App\Http\Middleware\Permissions;

use App\Http\Middleware\CheckPermission;

class CanManageUsers extends CheckPermission
{
    protected $permission = 'manage users';
}
