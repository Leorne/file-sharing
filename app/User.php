<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_path', 'status_message',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

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

    public function getStatusMessageAttribute($status){
        $default = '';
        return $status ? $status : $default;
    }
}
