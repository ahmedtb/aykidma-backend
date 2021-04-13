<?php

namespace App\Models;

use App\casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'meta_data' => Json::class,
        'fields' =>  Json::class,
        'service_id' => 'integer',
        'user_id' => 'integer',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
