<?php

namespace App\Http\Middleware\Permissions;

use App\Http\Middleware\CheckPermission;

class CanManageCompanyMeta extends CheckPermission
{

    protected $permission = 'manage company meta';

}
