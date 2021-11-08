<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Filters\UserNotificationFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title','body','type','user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query, UserNotificationFilters $filters)
    {
        return $filters->apply($query);
    }
}
