<?php

namespace App\Models;

use App\casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProvider extends Model
{
    use HasFactory;

    protected $casts = [
        'meta_data' => Json::class,
    ];
    
    protected $guarded = [];

    public function Services()
    {
        return $this->hasMany(Service::class);
    }
}
