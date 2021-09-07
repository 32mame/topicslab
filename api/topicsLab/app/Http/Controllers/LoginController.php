<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $trashedUser = User::onlyTrashed()->where('email', $request->email)->exists();
        if($trashedUser){
            return response()->json([
                'message' => 'DeletedUser'
            ], 401);
        }
        if (Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'success'
            ], 200);
        }
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
        
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'Logged out'
        ], 200);
    }
}
