<?php

namespace App\Models;

use App\Models\Database;
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
        'observation',
        'sended_at',
        'last_sended_at'
        'database_id',
    ];

    public function database()
    {
        return $this->belongsTo(Database::class);
    }
}
