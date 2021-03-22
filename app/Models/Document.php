<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    const TYPE_SOP = 0;

    const TYPE_POLICY = 1;

    protected $fillable = [
        'title',
        'slug',
        'categories',
        'tags',
        'type',
        'departments',
        'favourites',
        'is_public',
        'exam_minimum_score',
        'exam_max_duration'
    ];

    protected $casts = [
        'categories' => 'json',
        'tags' => 'json',
        'departments' => 'json',
        'favourites' => 'json'
    ];

    protected $appends = ['last_update', 'type_name', 'latest_version'];

    public function quizzes()
    {
        return $this->hasMany(DocumentQuiz::class);
    }

    public function getLastUpdateAttribute()
    {
        return $this->updated_at->diffForHumans();
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getTypeNameAttribute()
    {
        $types = ['SOP', 'POLICY'];

        return $types[$this->type];
    }

    public function exams()
    {
        return $this->hasMany(DocumentExam::class);
    }

    public function versions()
    {
        return $this->hasMany(DocumentVersion::class)->orderBy('created_at', 'desc');
    }

    public function getLatestVersionAttribute()
    {
        return $this->versions()->latest()->first();
    }
}
