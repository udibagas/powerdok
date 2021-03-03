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
    ];

    protected $casts = ['quizzes' => 'json'];

    protected $appends = ['score', 'status', 'correct_answer'];

    public function getCorrectAnswerAttribute()
    {
        return count(array_filter($this->quizzes, function($quiz) {
            return $quiz['correct_answer'] == $quiz['user_answer'];
        }));
    }

    public function getScoreAttribute()
    {
        return round(($this->correctAnswer / count($this->quizzes)), 2) * 100;
    }

    public function getStatusAttribute()
    {
        return $this->score >= 70 ? 'PASS' : 'FAILED';
    }
}
