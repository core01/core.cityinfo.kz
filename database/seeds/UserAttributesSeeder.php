<?php

use Illuminate\Database\Seeder;
use \App\Models\User;
use \App\Models\UserAttributes;

class UserAttributesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = User::all();
        foreach($users as $user){
           UserAttributes::firstOrCreate(['user_id' => $user->id]);
        }
    }
}
