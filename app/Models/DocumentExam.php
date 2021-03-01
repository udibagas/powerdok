<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentExam extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'user_id',
        'document_id',
        'quizzes',
        'status'
    ];
}
