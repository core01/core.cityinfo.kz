<?php

namespace App\Http\Middleware\Permissions;

use App\Http\Middleware\CheckPermission;

class CanManageImage extends CheckPermission
{
    protected $permission = 'manage images';
}
