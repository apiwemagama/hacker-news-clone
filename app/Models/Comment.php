<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'hn_id',
        'story_id',
        'parent_id',
        'by',
        'text',
        'time'
    ];

    protected $dates = ['time'];

    public function story()
    {
        return $this->belongsTo(Story::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}