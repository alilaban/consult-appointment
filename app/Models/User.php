<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'full_name',
        'image',
        'age',
        'email',
        'phone_number',
        'password',
        'is_expert'
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function favorites()
    {
        return $this->hasMany(Favorite::class );
    }

    //we need has many appointment
}
