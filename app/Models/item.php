<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'itemcategory_id', 'unit', 'brand', 'stock', 'item', 'image'];
}
