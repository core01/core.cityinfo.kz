<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {

        $user = Auth::user();
        return view('profile', [
            'user' => $user
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name'                  => 'required|string|max:190',
            'email'                 => 'required|string|email|max:190|unique:users,email,' . $user->id,
            'password'              => 'nullable|string|min:6',
            'password_confirmation' => 'nullable|required_with:password|string|min:6',

        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return back()->withInput()->with(['message' => __('content.profile_updated')]);
    }
}