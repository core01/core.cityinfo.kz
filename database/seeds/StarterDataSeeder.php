<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use \Illuminate\Support\Facades\Auth;
use \App\Models\User;

class StarterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $admin = Role::firstOrCreate(['name' => 'admin'], ['name' => 'admin']);
        $user = Role::firstOrCreate(['name' => 'user'], ['name' => 'user']);
        $user = User::role('admin')->first();
        if (!$user) {
            $user = new User();
            $user->name = 'Super Admin';
            $user->email = 'admin@example.com';
            $user->password = bcrypt('admin');
            $user->save();
        }
        Auth::login($user);
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // create permissions

        $deleteUsers = Permission::firstOrCreate(['name' => 'delete users']);
        $manageUsers = Permission::firstOrCreate(['name' => 'manage users']);
        $manageCm = Permission::firstOrCreate(['name' => 'manage company meta']);
        $manageImages = Permission::firstOrCreate(['name' => 'manage images']);


        if (!$user->hasRole($admin->name)) {
            $user->assignRole($admin->name);
        }
        if (!$admin->hasPermissionTo($deleteUsers->name)) {
            $admin->givePermissionTo($deleteUsers->name);
        }
        if (!$admin->hasPermissionTo($manageUsers->name)) {
            $admin->givePermissionTo($manageUsers->name);
        }
        if (!$admin->hasPermissionTo($manageCm->name)) {
            $admin->givePermissionTo($manageCm->name);
        }


    }
}
