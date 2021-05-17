<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone_number',
        'password',
        'phone_number_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'phone_number_verified_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }


    // public function tokens()
    // {
    //     return $this->morphMany(ExpoToken::class, 'notifiable');
    // }

    public function routeNotificationForExpoApp()
    {
        return $this->expoTokens();

        // return $this->hasMany(ExpoToken::class);
    }

    public function expoTokens()
    {
        return $this->hasManyThrough(ExpoToken::class, PersonalAccessToken::class, 'tokenable_id')
            ->where('tokenable_type', User::class);
    }
}
