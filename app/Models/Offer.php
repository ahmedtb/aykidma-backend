<?php

namespace App\Models;

use App\casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $casts = [
        'meta_data' => Json::class,
        'fields' =>  Json::class
    ];

    protected $guarded = [];

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
