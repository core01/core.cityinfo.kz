<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function getPermissions(Request $request)
    {
        return response()->json(['permissions' => Auth::user()->getAllPermissions()]);
    }
}
