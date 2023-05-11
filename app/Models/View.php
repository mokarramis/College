<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ip',
        'viewed_videos',
        'downloades',
        'created_at'
    ];

    public $timestamps = false;

}
