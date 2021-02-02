<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessControl extends Model
{
    use HasFactory;

    protected $fillable = [
        'authorizable_type', 'authorizable_id', 'action', 'allow', 'model'
    ];

    public static function check($user, $model, $action)
    {
        $allowedGroup = false;

        if ($user->userGroup) {
            $allowedGroup = self::where('authorizable_id', $user->userGroup->id)
                ->where('authorizable_type', UserGroup::class)
                ->where('action', $action)
                ->where('allow', true)
                ->where('model', $model)
                ->first();
        }

        $allowedUser = self::where('user_id', $user->id)
            ->where('authorizable_type', User::class)
            ->where('action', $action)
            ->where('allow', true)
            ->where('model', $model)
            ->first();

        return $allowedGroup || $allowedUser;
    }
}
