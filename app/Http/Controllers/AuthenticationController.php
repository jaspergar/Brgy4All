<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    //
    public function index(Request $req)
    {
        //first check if you are loggedin
        if (!Auth::check() && $req->path() != 'login') {
            return redirect('/login');
        }
        if (!Auth::check() && $req->path() == 'login') {
            return view('welcome');
        }

        //if you are already logged in... so check for if you are an admin user(Editor or Admin)
        $user = Auth::user();
        if ($user->userType == 'Worker' || $user->userType == 'Citizen') {
            return redirect('/login');
        }
        if ($req->path() == 'login') {
            return redirect('/');
        }
        return view('welcome');
    }

    public function adminLogin(Request $req)
    {
        $this->validate($req, [
            'email' => 'required',
            'password' => 'bail|required|min:6',
        ]);

        if (Auth::attempt([
            'email' => $req->email,
            'password' => $req->password
        ])) {
            //check if the user is an admin user, if not logout the user.
            $user = Auth::user();
            if ($user->userType == 'Citizen' || $user->userType == 'Worker') {
                Auth::logout();
                return response()->json([
                    'msg' => 'Incorrect login credentials'
                ], 401);
            }
            //else if user is an admin user logged him in.
            return response()->json([
                'msg' => 'You are logged in',
            ]);
        } else {
            return response()->json([
                'msg' => 'Incorrect login credentials'
            ], 401);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
