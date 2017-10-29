<?php

namespace App\Http\Controllers;

use App\Models\MODX\CompanyCardMeta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ManagerController extends Controller
{
    //
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('manager.main', []);
    }

    public function renderUsers(Request $request)
    {
        $users = User::with(['attributes', 'roles'])->get();
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        return view('manager.users', ['users' => $users, 'roles' => $roles, 'permissions' => $permissions]);
    }

    public function renderCompanyMeta(Request $request)
    {
        return view('manager.company-meta');
    }

    public function getCompanyMeta(Request $request)
    {
        $card = CompanyCardMeta::where(['id_iobj' => $request->company_id])->first();
        if (empty($card)) {
            return response()->json([
                'success' => true,
                'data'    => false,
            ]);
        } else {
            return response()->json([
                'success' => true,
                'data'    => [
                    'id'          => $card->id,
                    'company_id'  => $card->id_iobj,
                    'description' => $card->description
                ]
            ]);
        }

    }

    public function saveCompanyMeta(Request $request)
    {
        $request->validate([
            'company_id'  => 'required|integer',
            'description' => 'required|string|max:255'
        ]);

        $card = CompanyCardMeta::updateOrCreate(
            ['id_iobj' => $request->company_id],
            ['description' => $request->description]
        );
        return response()->json([
            'success' => true,
            'data'    => [
                'card_id'     => $card->id,
                'company_id'  => $card->id_iobj,
                'description' => $card->description,
            ]
        ]);
    }

    public function saveUser(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'role.id'    => 'required|integer',
            'user.email' => 'required|string|email|max:190|unique:users,email,' . $user->id,
            'user.name'  => 'required|string|max:190',
        ]);
        $user->name = $request->user['name'];
        $user->email = $request->user['email'];
        $user->save();
        $role = Role::where('id', $request->role['id'])->first();
        $user->syncRoles([$role->name]);


        return response()->json(['user' => $user, 'roles' => $user->getRoleNames()]);
    }

    public function getRolePermissions(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);
        $userPermissions = Role::findByName($request->name)->permissions;
        $allPermissions = Permission::all(['id', 'name', 'guard_name']);
        foreach ($allPermissions as &$permission) {
            $permission->roleHasThis = false;
            foreach ($userPermissions as $userPermission) {
                if ($userPermission->id === $permission->id) {
                    $permission->roleHasThis = true;
                }
            }
        }

        return response()->json(['permissions' => $allPermissions]);
    }

    public function createRole(Request $request)
    {
        $request->validate([
            'role_name' => 'required|string||max:30|unique:roles,name',
        ]);
        $role = Role::create(['name' => $request->role_name]);
        return response()->json($role);
    }

    public function saveRole(Request $request)
    {
        $request->validate([
            'role.name' => 'required|string|max:30',
            'role.id'   => 'required|integer',
        ]);
        if ($request->permissions) {
            $request->validate(
                [
                    'permissions.*.name'        => 'required|string',
                    'permissions.*.id'          => 'required|integer',
                    'permissions.*.roleHasThis' => 'required|boolean',
                ]);
        }
        $role = Role::where('id', $request->role['id'])->first();
        if ($role->name !== $request->role['name']) {
            $role->name = $request->role['name'];
            $role->save();
        }
        $rolePermissions = [];
        foreach ($request->permissions as $permission) {
            if ($permission['roleHasThis'] === true) {
                $rolePermissions[] = $permission['name'];
            }
        }
        $role->syncPermissions($rolePermissions);
        return response()->json(true);
    }

    public function deleteRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string|',
            'id'   => 'required|integer',
        ]);
        if ($role = Role::find($request->id)) {
            $role->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 422);
    }
}
