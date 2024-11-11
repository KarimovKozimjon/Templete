<?php

namespace App\Models;

use App\Notifications\NewFollowerNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'avatar',
        'username',
        'verification_token', // verification_token ustunini qo'shamiz
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Emailni tasdiqlash
    public function markEmailAsVerifiedManually()
    {
        $this->email_verified_at = now();  // Emailni tasdiqlash
        $this->verification_token = null;  // Tokenni o'chirish
        $this->save();
    }

    // Email tasdiqlanganligini tekshirish
    public function hasVerifiedEmail()
    {
        return !is_null($this->email_verified_at);  // Agar email tasdiqlangan bo'lsa true qaytaradi
    }

    // Boshqa metodlar
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Kuzatadigan foydalanuvchilar
// User modelida

// User Modelidagi methodlar
public function followers()
{
    return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id');
}

public function following()
{
    return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id');
}

    

    // Follow qilish va notification yuborish
    public function follow(User $user)
    {
        if (!$this->isFollowing($user)) {
            $this->following()->attach($user->id);  // Follow aloqasini yaratish
            $user->notify(new NewFollowerNotification($this)); // Notification yuborish
        }
    }

    public function unfollow(User $user)
    {
        return $this->following()->detach($user->id);
    }

    public function isFollowing(User $user)
    {
        return $this->following()->where('followed_id', $user->id)->exists();
    }

    // Followerlar soni
    public function followersCount()
    {
        return $this->followers()->count();
    }

    // Following soni
    public function followingCount()
    {
        return $this->following()->count();
    }
}
