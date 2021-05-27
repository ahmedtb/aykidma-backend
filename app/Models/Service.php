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
        'service_provider_id' => 'integer',
        'offer_id' => 'integer',
        'rating' => 'float',
        'approved' => 'boolean',
        'fields' =>  Json::class,
        'category_id' => 'integer'
    ];

    protected $guarded = [];

    public function ServiceProvider() {
        return $this->belongsTo(ServiceProvider::class);
    }

    // public function offer() {
    //     return $this->belongsTo(Offer::class);
    // }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // public function services()
    // {
    //     return $this->hasMany(Service::class);
    // }

    public function approvedServices()
    {
        return $this->hasMany(Service::class)->where('approved',true);
    }
}
