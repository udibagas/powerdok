<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskTracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'user_id',
        'status'
    ];

    protected $with = ['user'];

    protected $appends = ['status_label'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function getStatusLabelAttribute()
    {
        return Task::getStatusLabel($this->status);
    }
}
