<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExpoToken extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function PersonalAccessToken() {
        return $this->belongsTo(PersonalAccessToken::class,'personal_access_tokens_id');
    }
}
