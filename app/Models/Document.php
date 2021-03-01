<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Document extends Model
{
    use HasFactory;

    const TYPE_SOP = 0;

    const TYPE_POLICY = 1;

    protected $fillable = [
        'title',
        'slug',
        'categories',
        'tags',
        'type',
        'number',
        'version',
        'departments',
        'effective_date',
        'expired_date',
        'owner_id',
        'favourites',
        'is_public'
    ];

    protected $casts = [
        'categories' => 'json',
        'tags' => 'json',
        'departments' => 'json',
        'favourites' => 'json'
    ];

    protected $with = ['owner'];

    protected $appends = ['last_update', 'type_name'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

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
}
