<?php

namespace App\Models;

use App\casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $casts = [
        'meta_data' => Json::class,
    ];

    public function ServiceProvider() {
        return $this->belongsTo(ServiceProvider::class);
    }

    public function offer() {
        return $this->belongsTo(Offer::class);
    }
}
