<?php

namespace App\Models;

use App\casts\Json;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;
use App\Models\ProviderNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ServiceProvider extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $casts = [
        'address' => Json::class,
        'coverage' => Json::class,
        'meta_data' => Json::class,
    ];

    protected $hidden = [
        'password',
        'image'
    ];

    protected $guarded = [];

    public function Services()
    {
        return $this->hasMany(Service::class);
    }

    public function Orders()
    {
        return $this->hasManyThrough(Order::class, Service::class);
    }

    public function notifications(){
        return $this->hasMany(ProviderNotification::class);
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
}
