<?php

namespace App\Models;

use App\Http\Controllers\DocumentController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attestation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'document_id',
        'due_date',
        'status',
        'user_id',
        'description',
    ];

    protected $with = ['document'];

    public function document()
    {
        return $this->belongsTo(DocumentController::class, 'document_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignees()
    {
        return $this->hasManyThrough(User::class, AttestationAssignment::class, 'user_id', 'id');
    }
}
