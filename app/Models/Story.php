<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Story extends Model
{
    use HasFactory;

    protected $fillable = [
        'hn_id',
        'title',
        'url',
        'score',
        'by',
        'time',  // This should be a timestamp
        'type',
        'text'
    ];

    // For Laravel 8+ (recommended)
    protected $casts = [
        'time' => 'datetime',
    ];

    // For Laravel < 8 (alternative)
    // protected $dates = ['time'];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the time attribute properly cast to Carbon
     */
    protected function time(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => \Carbon\Carbon::parse($value),
            set: fn ($value) => is_numeric($value) 
                ? \Carbon\Carbon::createFromTimestamp($value) 
                : $value,
        );
    }
}