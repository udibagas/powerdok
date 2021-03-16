<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mews\Purifier\Facades\Purifier;

class TaskApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'level',
        'user_id',
        'status',
        'note'
    ];

    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getNoteAttribute($value)
    {
        return Purifier::clean(nl2br($value));
    }
}
