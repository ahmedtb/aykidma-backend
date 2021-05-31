<?php

namespace App\Models;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'path', 'filename'
    ];

    public static function boot()
    {
        parent::boot();

        Image::deleted(function ($image) {
            deletePublicFile($image->path);
        });
    }

    public static function createWithBase64(string $base64)
    {
        $path = storeBase64PngFile($base64);
        $pieces  = explode("storage/", $path);
        $fileName = $pieces[1];
        return parent::create([
            'path' => $path,
            'filename' => $fileName
        ]);
    }
}
