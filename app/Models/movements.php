<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class movements extends Model
{
    use HasFactory;

    protected $fillable=[
        'id','supplieritem_id','user_id','lastAction', 'totalReleased',
        'status','type', 'dateReleased','datePurchased','dateWasted','dateCancelled','qty', 'notification', 'status', 'reasonforcancel',
    ];
}
