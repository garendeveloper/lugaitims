<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class movements extends Model
{
    use HasFactory;

    protected $fillable=[
        'id','supplieritem_id','user_id','lastAction','quantity',
        'cost', 'totalCost','status','type','remarks', 'date', 'dateReleased','datePurchased'
    ];
}
