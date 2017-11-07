<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    //
    public function getAll()
    {
        return response()->json(['permissions' => Permission::all()]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'guard_name' => 'required|string|max:30',
            'name'       => 'required|string|max:190'
        ]);
        $permission = Permission::where([
            'guard_name' => $request->guard_name,
            'name'       => $request->name,
        ])->get();

        if (count($permission) > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Permission должен быть уникальным в пределах guard'
            ], 422);
        } else {
            $permission = new Permission();
            $permission->name = $request->name;
            $permission->guard_name = $request->guard_name;
            $permission->save();
            return response()->json($permission);
        }
    }

    public function save(Request $request, $id = null)
    {
        $request->validate([
            'guard_name' => 'required|string|max:30',
            'name'       => 'required|string|max:190',
            'id'         => 'integer'
        ]);

        $permission = Permission::find($id);

        $permission->guard_name = $request->guard_name;
        $permission->name = $request->name;
        $permission->save();

        return response()->json($permission, 201);

    }

    public function delete($id)
    {
        $permission = Permission::find($id);
        $permission->delete();
        $permissions = Permission::all();
        return response()->json(['permissions' => $permissions]);
    }
}
