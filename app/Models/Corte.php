<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Corte extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'path',
        'user_id'
    ];

    protected $appends = [
        // 'fileContent',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
