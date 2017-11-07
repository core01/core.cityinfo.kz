<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    //
    public function getAll()
    {
        $roles = Role::with('permissions')->get();
        return response()->json(['roles' => $roles]);
    }
}
