<?php

namespace App\Models;

use App\casts\Json;
use App\Filters\ServiceFilters;
use App\Casts\CastsArrayOfFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $casts = [
        'meta_data' => Json::class,
        'service_provider_id' => 'integer',
        'offer_id' => 'integer',
        'rating' => 'float',
        'approved' => 'boolean',
        'array_of_fields' =>  CastsArrayOfFields::class,
        'category_id' => 'integer',
        'price' => 'integer'
    ];

    protected $guarded = [];

    protected $hidden = ['phone_number'];

    public function ServiceProvider()
    {
        return $this->belongsTo(ServiceProvider::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function approvedServices()
    {
        return $this->hasMany(Service::class)->where('approved', true);
    }

    public function reviews()
    {
        return $this->hasManyThrough(Review::class,Order::class)->with(['user:id,name']);
        // return $this->hasMany(Order::class)->where('status', 'done')->with(['user:id,name'])->select(['service_id','comment', 'rating', 'user_id']);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function averageRating()
    {
    }

    public function scopeApproved($query, $bool = true)
    {
        return $query->where('approved', $bool);
    }
    
    public function scopeFilter($query, ServiceFilters $filters)
    {
        return $filters->apply($query);
    }
}
