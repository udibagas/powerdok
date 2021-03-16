<?php

namespace App\Models;

use Carbon\Carbon;
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

    protected $casts = ['quizzes' => 'json'];

    protected $appends = ['score', 'passed', 'correct_answer', 'duration'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function getCorrectAnswerAttribute()
    {
        return count(array_filter($this->quizzes, function ($quiz) {
            return $quiz['correct_answer'] === $quiz['user_answer'];
        }));
    }

    public function getScoreAttribute()
    {
        return round($this->correctAnswer / count($this->quizzes)) * 100;
    }

    public function getPassedAttribute()
    {
        return $this->score >= $this->exam_minimum_score;
    }

    public function getDurationAttribute()
    {
        $start = new Carbon($this->time_start);
        $finished = new Carbon($this->time_finished);

        return $finished->diff($start)->format('%H:%I:%S');
    }
}
