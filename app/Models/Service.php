<?php

namespace App\Models;

use App\Http\Controllers\ServicesController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $casts = [
        'meta_data' => 'object',
    ];

    public function ServiceProvider() {
        return $this->belongsTo(ServiceProvider::class);
    }
}
