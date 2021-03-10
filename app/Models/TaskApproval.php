<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
