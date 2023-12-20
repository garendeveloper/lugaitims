<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class supplier extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'contact_number', 'address', 'vatReg', 'tin'];
}
