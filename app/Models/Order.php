<?php

namespace App\Models;

use App\casts\Json;
use App\Casts\CastsArrayOfFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use PDO;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'meta_data' => Json::class,
        'array_of_fields' =>  CastsArrayOfFields::class,
        'service_id' => 'integer',
        'user_id' => 'integer',
        'rating' => 'integer',
        'cost' => 'integer'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function provider(){
        return $this->service->ServiceProvider();

    }
}
