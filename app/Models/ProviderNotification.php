<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title','body','type','service_provider_id'
    ];
}
