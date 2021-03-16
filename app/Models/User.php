<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Musonza\Chat\Traits\Messageable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use HasRoles;
    use Messageable;

    const ROLE_SUPER_ADMIN = 99;

    const ROLE_ENTERPRISE_ADMIN = 88;

    const ROLE_DOCUMENT_ADMIN = 77;

    const ROLE_USER = 66;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'position', 'department_id', 'password', 'status'
    ];

    protected $with = ['department'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function receivesBroadcastNotificationsOn()
    {
        return 'users.' . $this->id;
    }

    public function getParticipantDetailsAttribute()
    {
        return [
            'name' => $this->name,
            'department' => $this->department ? $this->department->name : '',
            'position' => $this->position,
        ];
    }
}
