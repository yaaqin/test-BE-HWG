<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class actifity extends Model
{
    use HasFactory;

    protected $table = 'actifity';

    protected $fillable = [
        'user_id',
        'book_id',
        'actifity'
    ];
}
