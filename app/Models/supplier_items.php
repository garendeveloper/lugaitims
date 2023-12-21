<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class supplier_items extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'supplier_id', 'item_id', 'stock', 'serialnumber', 'modelnumber', 'no_ofYears', 'category_id', 'quantity',
    'cost', 'totalCost','status','type','remarks', 'date',];
}
