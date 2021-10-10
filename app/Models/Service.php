<?php

namespace App\Models;

use App\casts\Json;
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

    protected $appends = ['category'];

    public function getCategoryAttribute(){
        return $this->category()->first();
    }

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
        return $this->hasMany(Order::class)->where('status','done')->select(['comment','rating']);
    }

    public function averageRating()
    {
        
    }
}
