<?php

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProviderEnrollmentRequest extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'coverage' => Json::class,
    ];
}
