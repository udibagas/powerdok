<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'tags',
        'categories',
        'number',
        'version',
        'departments',
        'effective_date',
        'expired_date',
        'owner_id',
        'favourites',
        'type',
        'is_public'
    ];

    protected $casts = [
        'tags' => 'json',
        'categories' => 'json',
        'departments' => 'json',
        'favourites' => 'json'
    ];

    protected $with = ['owner'];

    protected $appends = ['last_update'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function getLastUpdateAttribute()
    {
        return $this->updated_at->diffForHumans();
    }
}
