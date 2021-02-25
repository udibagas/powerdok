<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentQuiz extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'document_id',
        'question',
        'choices',
        'correct_answer'
    ];

    protected $casts = ['choices' => 'json'];

    protected $with = ['attachments'];

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
