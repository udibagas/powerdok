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
        'exam_minimum_score',
        'exam_max_duration',
        'time_start',
        'time_finished'
    ];

    protected $appends = ['score', 'passed', 'correct_answer'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function getCorrectAnswerAttribute()
    {
        return count(array_filter($this->quizzes, function ($quiz) {
            return $quiz->correct_answer == $quiz->user_answer;
        }));
    }

    public function getScoreAttribute()
    {
        return round(($this->correctAnswer / count($this->quizzes)), 2) * 100;
    }

    public function getPassedAttribute()
    {
        return $this->score >= $this->exam_minimum_score;
    }

    public function getQuizzesAttribute($value)
    {
        if (
            in_array(
                $this->task->status,
                [Task::STATUS_DRAFT, Task::STATUS_ON_PROGRESS, Task::STATUS_SUBMITTED, Task::STATUS_VOID]
            )
            && $this->user_id != auth()->id()
        ) {
            return array_map(function ($quiz) {
                $quiz->correct_answer = null;
                return $quiz;
            }, json_decode($value));
        }

        return json_decode($value);
    }
}
