<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentVersion extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_DRAFT = 0;

    const STATUS_SUBMITTED = 1;

    const STATUS_PUBLISHED = 2;

    protected $fillable = [
        'document_id',
        'number',
        'version',
        'effective_date',
        'expired_date',
        'owner_id',
        'body',
        'status'
    ];

    protected $with = ['owner'];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
