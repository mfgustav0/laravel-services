<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale',
        'client',
        'type',
        'status',
        'database',
        'observation',
        'sended_at',
        'last_sended_at'
    ];
}
