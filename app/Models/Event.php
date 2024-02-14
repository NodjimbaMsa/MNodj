<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'event_date'
    ];

    public function scopeScheduledAtBetween($query, $start, $end)
    {
        return $query->whereBetween('event_date', [$start, $end]);
    }
}
