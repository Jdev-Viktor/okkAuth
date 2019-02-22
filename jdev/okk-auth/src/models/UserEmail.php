<?php

namespace jDev\OkkAuth\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserEmail
 *
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property string $email
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\jDev\OkkAuth\Models\UserEmail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\jDev\OkkAuth\Models\UserEmail whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\jDev\OkkAuth\Models\UserEmail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\jDev\OkkAuth\Models\UserEmail whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\jDev\OkkAuth\Models\UserEmail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\jDev\OkkAuth\Models\UserEmail whereUserId($value)
 * @mixin \Eloquent
 */
class UserEmail extends Model
{
    const TYPE_PRIMARY = 'PRIMARY';
    const TYPE_ADDITIONAL = 'ADDITIONAL';
    const TYPE_MANUAL = 'MANUAL';

    protected $fillable = [
        'type', 'email',
    ];


    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
