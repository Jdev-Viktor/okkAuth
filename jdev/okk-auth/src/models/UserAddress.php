<?php

namespace jDev\OkkAuth\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserAddress
 *
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property string|null $country
 * @property string|null $country_code
 * @property string|null $state
 * @property string|null $city
 * @property string|null $district
 * @property string|null $street
 * @property string|null $building
 * @property string|null $apartment
 * @property string|null $postcode
 * @property string|null $lat
 * @property string|null $lon
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\jDev\OkkAuth\Models\UserAddress whereApartment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\jDev\OkkAuth\Models\UserAddress whereBuilding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\jDev\OkkAuth\Models\UserAddress whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\jDev\OkkAuth\Models\UserAddress whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\jDev\OkkAuth\Models\UserAddress whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\jDev\OkkAuth\Models\UserAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\jDev\OkkAuth\Models\UserAddress whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\jDev\OkkAuth\Models\UserAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\jDev\OkkAuth\Models\UserAddress whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\jDev\OkkAuth\Models\UserAddress whereLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\jDev\OkkAuth\Models\UserAddress wherePostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\jDev\OkkAuth\Models\UserAddress whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\jDev\OkkAuth\Models\UserAddress whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\jDev\OkkAuth\Models\UserAddress whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\jDev\OkkAuth\Models\UserAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\jDev\OkkAuth\Models\UserAddress whereUserId($value)
 * @mixin \Eloquent
 */
class UserAddress extends Model
{
    const ADDRESS_TYPE_LIVING = 'FACTUAL';
    const ADDRESS_TYPE_REGISTRATION = 'REGISTRATION';

    protected $fillable = [
        'type', 'country', 'country_code', 'state', 'city', 'district', 'street',
        'building', 'apartment', 'postcode', 'lat', 'lon',
    ];

    public function getFullAddressAttribute()
    {
        return $this->city . ', ' . $this->street . ' ' . $this->building . ', ' . $this->apartment;
    }


    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
