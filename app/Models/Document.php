<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'number',
        'version',
        'departments',
        'effective_date',
        'expired_date',
        'owner_id',
        'favorite',
    ];

    protected $casts = [
        'category' => 'json',
        'departments' => 'json',
        'favorite' => 'json'
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
