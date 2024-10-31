<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateProfileRequest; 

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

 
   public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
    
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Berilgan parol bizning malumotlarimiz bilan mos kelmaydi.']);
        }
    
        DB::transaction(function () use ($request, $user) {
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
    
            if ($request->hasFile('avatar')) {
                if ($user->avatar) {
                    Storage::delete($user->avatar);
                }
                $path = $request->file('avatar')->store('avatars', 'public');
                $user->avatar = $path;
            }
    
            if ($request->new_password) {
                $user->password = bcrypt($request->new_password);
            }
    
            $user->save();
        });
    
        return redirect()->route('profile.show')->with('success', 'Profil muvaffaqiyatli yangilandi.');
    }
    
    

    public function logout()
    {
        Auth::logout();
        return redirect("/");
    }
}
