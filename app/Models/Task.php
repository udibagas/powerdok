<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mews\Purifier\Facades\Purifier;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    // Status

    const STATUS_SUBMITTED = 0;

    const STATUS_ON_PROGRESS = 1;

    const STATUS_FINALIZED = 2;

    const STATUS_APPROVAL = 3;

    const STATUS_PARTIALLY_APPROVED = 4;

    const STATUS_APPROVED = 5;

    const STATUS_FINISHED = 6;

    const STATUS_CLOSED = 7;

    const STATUS_VOID = 8;

    const STATUS_POSTPONED = 9;

    // Priorities

    const PRIORITY_LOW = 0;

    const PRIORITY_MEDIUM = 1;

    const PRIORITY_HIGH = 2;

    const PRIORITY_URGENT = 3;

    // Task Types

    const TYPE_DOCUMENT_REVIEW = 1;

    const TYPE_ATESTATION = 2;

    const TYPE_EXAMINATION = 3;

    protected $fillable = [
        'user_id',
        'type',
        'document_id',
        'title',
        'description',
        'custom_fields',
        'priority',
        'due_date',
        'status',
        'assignee_id'
    ];

    protected $casts = [
        'custom_fields' => 'json'
    ];

    protected $appends = [
        'status_label',
        'priority_label',
        'type_name',
        'overdue',
        'is_closed'
    ];

    protected $with = [
        'assignee',
        'document'
    ];

    public function getDescriptionAttribute($value)
    {
        return Purifier::clean($value);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }

    public function exam()
    {
        return $this->hasOne(DocumentExam::class);
    }

    public function approvals()
    {
        return $this->hasMany(TaskApproval::class)->orderBy('level', 'asc');
    }

    public function trackings()
    {
        return $this->hasMany(TaskTracking::class);
    }

    public function getStatusLabelAttribute()
    {
        return static::getStatusLabel($this->status);
    }

    public function getPriorityLabelAttribute()
    {
        $priorityList = static::priorityList();

        return isset($priorityList[$this->priority]) ? $priorityList[$this->priority] : 'N/A';
    }

    public function getOverdueAttribute()
    {
        if (!$this->due_date) {
            return false;
        }

        return Carbon::now() > (new Carbon($this->due_date));
    }

    public function getIsClosedAttribute()
    {
        return in_array($this->status, [
            self::STATUS_CLOSED,
            self::STATUS_FINISHED,
            self::STATUS_VOID,
        ]);
    }

    public static function getStatusLabel($status)
    {
        $statusList = static::statusList();

        return isset($statusList[$status]) ? $statusList[$status] : 'N/A';
    }

    public function getTypeNameAttribute()
    {
        $types = static::typeList();

        return isset($types[$this->type]) ? $types[$this->type] : 'N/A';
    }

    public static function typeList()
    {
        return [
            self::TYPE_DOCUMENT_REVIEW => 'Document Review',
            self::TYPE_ATESTATION => 'Atestation',
            self::TYPE_EXAMINATION => 'Examination'
        ];
    }

    public static function statusList()
    {
        return [
            self::STATUS_SUBMITTED => 'New',
            self::STATUS_ON_PROGRESS => 'On Progress',
            self::STATUS_FINISHED => 'Finished',
            self::STATUS_CLOSED => 'Closed',
            self::STATUS_VOID => 'Void',
            self::STATUS_POSTPONED => 'Postponed'
        ];
    }

    public static function priorityList()
    {
        return [
            self::PRIORITY_LOW => 'Low',
            self::PRIORITY_MEDIUM => 'Medium',
            self::PRIORITY_HIGH => 'High',
            self::PRIORITY_URGENT => 'Urgent'
        ];
    }
}
