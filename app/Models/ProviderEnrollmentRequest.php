<?php

namespace App\Models;

use App\Casts\Json;
use App\Filters\ProviderEnrollmentRequestFilters;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProviderEnrollmentRequest extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'coverage' => Json::class,
    ];

    public function scopeFilter($query, ProviderEnrollmentRequestFilters $filters)
    {
        return $filters->apply($query);
    }
}
