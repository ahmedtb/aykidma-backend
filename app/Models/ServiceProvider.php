<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProvider extends Model
{
    use HasFactory;

    protected $casts = [
        'meta_data' => 'object',
    ];
    
    public function Services()
    {
        return $this->hasMany(Service::class);
    }
}
