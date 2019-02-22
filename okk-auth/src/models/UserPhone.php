<?php

namespace jDev\OkkAuth\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserPhone
 *
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property string $phone
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\jDev\OkkAuth\Models\UserPhone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\jDev\OkkAuth\Models\UserPhone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\jDev\OkkAuth\Models\UserPhone wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\jDev\OkkAuth\Models\UserPhone whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\jDev\OkkAuth\Models\UserPhone whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\jDev\OkkAuth\Models\UserPhone whereUserId($value)
 * @mixin \Eloquent
 */
class UserPhone extends Model
{

    const TYPE_PRIMARY = 'PRIMARY';
    const TYPE_ADDITIONAL = 'ADDITIONAL';
    const TYPE_MANUAL = 'MANUAL';

    protected $fillable = [
        'type', 'phone',
    ];


    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
