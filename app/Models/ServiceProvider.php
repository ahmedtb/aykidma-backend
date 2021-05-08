<?php

namespace App\Models;

use App\casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ServiceProvider extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $casts = [
        'meta_data' => Json::class,
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
}
