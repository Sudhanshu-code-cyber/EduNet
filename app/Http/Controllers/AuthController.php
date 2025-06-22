<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }
    public function userRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:users',
            'role' => 'required|in:admin,teacher,student',
            'password' => 'required|string|min:6',
        ]);

        User::create([
           'name' => $request->name,
           'contact' => $request->contact,
           'email' => $request->email,
           'role' => $request->role,
           'password' => $request->password,

        ]);
        return redirect()->route('home.login');

    }
  public function Userlogin(Request $request)
{
    if ($request->isMethod("post")) {
        $data = $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        if (Auth::attempt($data)) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect('/admin');
            } elseif ($user->role === 'teacher') {
                return redirect('/teacher');
            } elseif ($user->role === 'student') {
                return redirect('/student'); // ✅ Replace with your actual student route
            } else {
                Auth::logout(); // optional: prevent login with unknown role
                return redirect()->back()->withErrors(['role' => 'Unauthorized role']);
            }
        } else {
            return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
        }
    }

    return view('auth.login'); // ✅ show login form on GET request
}

public function logout(){
     Auth::logout();

        return redirect()->route("home.login");
}

}
