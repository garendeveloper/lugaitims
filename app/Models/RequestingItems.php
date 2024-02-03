<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestingItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'movement_id', 'user_id', 'qty', 'notification', 'status', 'reasonforcancel'
    ];

}
