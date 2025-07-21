<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Item extends Model
{
    use HasFactory;

    // Optional: If you're using guarded or fillable
    protected $fillable = [
        'title',
        'description',
    ];
}
