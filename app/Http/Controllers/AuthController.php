<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function registerForm()
    {
        return view("auth.register");
    }
    public function register(RegisterRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        // Avatarni saqlash
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public'); // 'public' diskda saqlash
            $user->avatar = $path;
        }

        $user->save();

        Auth::login($user);

        return redirect()->intended('/');
    }
    public function loginForm()
    {
        return view("auth.login");
    }
    public function login(LoginRequest $request)
    {
        $credentials = request()->only("email", "password");
        $user = User::where("email", $request->email)->first();
        if (!Hash::check($request->password, $user->password)) {
            return "error";
        }
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect("/profile");
        }
    }
}
