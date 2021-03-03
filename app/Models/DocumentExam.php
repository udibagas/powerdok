<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentExam extends Model
{
    use HasFactory;

    const STATUS_PASS = true;

    const STATUS_FAILED = false;

    protected $fillable = [
        'task_id',
        'user_id',
        'document_id',
        'quizzes',
        'minimum_score'
    ];

    protected $casts = ['quizzes' => 'json'];

    protected $appends = ['score', 'passed', 'correct_answer'];

    public function getCorrectAnswerAttribute()
    {
        return count(array_filter($this->quizzes, function ($quiz) {
            return $quiz['correct_answer'] == $quiz['user_answer'];
        }));
    }

    public function getScoreAttribute()
    {
        return round(($this->correctAnswer / count($this->quizzes)), 2) * 100;
    }

    public function getPassedAttribute()
    {
        return $this->score >= $this->minimum_score;
    }
}
