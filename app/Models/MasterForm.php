<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterForm extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'fields',
        'approvals',
        'owner_id',
        'published'
    ];

    protected $casts = [
        'fields' => 'json',
        'approvals' => 'json'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
