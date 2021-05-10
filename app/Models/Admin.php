<?php

namespace App\Models;

use App\Casts\Json;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use  HasApiTokens, HasFactory;

    protected $casts = [
        'address' => Json::class,
        'meta_data' => Json::class,
    ];
}
