<?php

namespace App\Models;

use App\Casts\Json;
use App\Enums\Mail\MailStatus;
use App\Models\Database;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
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
        'last_sended_at',
        'database_id',
    ];
    
    protected $casts = [
        'client' => Json::class,
        'sale' => Json::class,
        'status' => MailStatus::class
    ];

    public function database()
    {
        return $this->belongsTo(Database::class);
    }

    public function pendents(): Collection
    {
        return $this->whereIn('status', [MailStatus::PENDENT, MailStatus::FAILURE])
                ->get();
    }

    protected function type(): Attribute
    {
        return Attribute::make(
            get: fn($value) => str($value)->upper(),
        );
    }
}
