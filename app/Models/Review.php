<?php

namespace App\Models;

use App\Models\Order;
use App\Filters\ReviewFilters;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function service()
    {
        return $this->order->service();
    }
    
    public function scopeFilter($query, ReviewFilters $filters)
    {
        return $filters->apply($query);
    }
}
