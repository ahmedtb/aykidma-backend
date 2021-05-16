<?php

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $casts = [
        'meta_data' => Json::class,
        'service_provider_id' => 'integer',
        'offer_id' => 'integer',
        'rating' => 'float',
        'approved' => 'boolean'
    ];

    protected $guarded = [];

    public function ServiceProvider() {
        return $this->belongsTo(ServiceProvider::class);
    }

    public function offer() {
        return $this->belongsTo(Offer::class);
    }
}
