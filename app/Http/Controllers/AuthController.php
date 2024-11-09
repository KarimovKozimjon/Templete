<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\RegisterRequest;
use App\Mail\EmailVerificationMail; // Yangi mail sinfini chaqiramiz
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function registerForm()
    {
        return view("auth.register");
    }

    public function register(RegisterRequest $request)
    {
        // Yangi foydalanuvchi yaratish
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

        // Yangi tasdiqlash tokenini yaratish
        $user->verification_token = Str::random(60);

        $user->save();

        // Emailni yuborish (tasdiqlash linki bilan)
        Mail::to($user->email)->send(new EmailVerificationMail($user));

        // Foydalanuvchini tizimga kirish
        Auth::login($user);

        return redirect()->intended('/');
    }

    // Emailni tasdiqlash uchun metod
    public function verifyEmail($token)
    {
        $user = User::where('verification_token', $token)->first();

        if ($user) {
            // Foydalanuvchining emailini tasdiqlash
            $user->markEmailAsVerifiedManually();

            // Tasdiqlash muvaffaqiyatli bo'lsa, foydalanuvchini home sahifasiga yuboramiz
            return redirect('/login')->with('message', 'Email tasdiqlandi, iltimos tizimga kiring.');
        }

        // Agar token topilmasa, xatolik ko‘rsatamiz
        return redirect('/login')->with('error', 'Noto‘g‘ri yoki muddati o‘tgan token.');
    }

    public function loginForm()
    {
        return view("auth.login");
    }

    public function login(LoginRequest $request)
    {
        $credentials = request()->only("email", "password");
        $user = User::where("email", $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Foydalanuvchi topilmadi');
        }

        // Parolni tekshirish
        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Noto\'g\'ri parol');
        }

        // Email tasdiqlangani yoki yo'qligini tekshirish
        if (!$user->hasVerifiedEmail()) {
            return back()->with('error', 'Iltimos, emailingizni tasdiqlang!');
        }

        // Tizimga kirish
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect("/profile");
        }

        return back()->with('error', 'Tizimga kirishda xato!');
    }
}
