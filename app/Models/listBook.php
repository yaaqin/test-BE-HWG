<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class listBook extends Model
{
    use HasFactory;

    protected $table = 'listBook';

    protected $fillable = [
        "id",
        'nama',
        'kategory_id',
        'status',
    ];
}