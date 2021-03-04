<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Util\MimeType;

class Attachment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'path'
    ];

    protected $appends = ['url', 'size'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUrlAttribute()
    {
        return Storage::url($this->path, now()->addMinutes(5));
    }

    public function attachable()
    {
        return $this->morphTo();
    }

    public function getSizeAttribute()
    {
        return Storage::size($this->path);
    }
}
