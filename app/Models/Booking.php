<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'bed',
        'starts_at',
        'ends_at',
        // Add other fields as needed
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at'   => 'datetime',
    ];
    
    /**
     * RU: Связь -> Бронь принадлежит пользователю
     */
      public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
