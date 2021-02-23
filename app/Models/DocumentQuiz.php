<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentQuiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'question',
        'choices',
        'correct_answer'
    ];

    protected $casts = ['choices' => 'json'];

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }
}
