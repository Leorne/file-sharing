<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'avatar_path', 'status_message',
    ];

    protected $hidden = [
        'password', 'remember_token', 'email'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $withCount = ['replies','uploads'];


    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\ConfirmEmailNotification);
    }


    public function files()
    {
        return $this->hasMany(File::class)->latest();
    }

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    public function getAvatarPathAttribute($avatar)
    {
        $default = 'storage/avatars/default.png';
        return asset($avatar ? 'storage/'. $avatar : $default);
    }

    public function replies(){
        return $this->hasMany(Reply::class);
    }

    public function uploads(){
        return $this->hasMany(File::class);
    }

    public function getStatusMessageAttribute($status){
        $default = '';
        return $status ? $status : $default;
    }
}
