<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    use HasFactory;

    protected $table = 'book';

    protected $fillable = [
        "id",
        'user_id',
        'book_id',
        'status',
        'start_date',
        'end_date'
    ];
}
