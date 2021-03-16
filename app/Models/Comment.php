<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mews\Purifier\Facades\Purifier;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'body'
    ];

    protected $with = ['user', 'attachments'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function getBodyAttribute($value)
    {
        return Purifier::clean($value);
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
