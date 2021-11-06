<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Filters\UserFilters;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;
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
        'phone_number_verified_at',
        'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        // 'image',
        // 'phone_number'
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

    public function reviews()
    {
        return $this->hasManyThrough(Review::class, Order::class);
    }

    public function notifications()
    {
        return $this->hasMany(UserNotification::class);
    }

    /**
     * Create a new personal access token for the user.
     *
     * @param  string  $name
     * @param  array  $abilities
     * @return \Laravel\Sanctum\NewAccessToken
     */
    public function createToken(string $name, string $expo_token, array $abilities = ['*'])
    {
        $token = $this->tokens()->forceCreate([
            'tokenable_id' => $this->id,
            'tokenable_type' => static::class,
            'name' => $name,
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
            'expo_token' => $expo_token,
            'abilities' => $abilities,
        ]);

        return new NewAccessToken($token, $token->getKey() . '|' . $plainTextToken);
    }

    public function routeNotificationForExpoApp()
    {
        return $this->expoTokens();
    }

    public function expoTokens()
    {
        return $this->tokens()->pluck('expo_token')->unique();
    }

    public function provider()
    {
        return $this->hasOne(ServiceProvider::class, 'user_id');
    }
    public function scopeFilter($query, UserFilters $filters)
    {
        return $filters->apply($query);
    }
}
