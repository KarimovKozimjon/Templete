<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts; // Foydalanuvchining postlarini olish
        $followersCount = $user->followers()->count(); // Foydalanuvchini kuzatuvchilar soni
        $followingCount = $user->following()->count(); // Foydalanuvchini kuzatganlar soni
        return view('profile.user_profile', compact('user', 'posts', 'followersCount', 'followingCount'));
    }

    public function follow(User $user)
    {
        Auth::user()->follow($user);
        return back()->with('success', 'Siz ' . $user->name . 'ni kuzata boshladingiz.');
    }

    public function unfollow(User $user)
    {
        Auth::user()->unfollow($user);
        return back()->with('success', 'Siz ' . $user->name . 'ni kuzatishni to\'xtatdingiz.');
    }
}
