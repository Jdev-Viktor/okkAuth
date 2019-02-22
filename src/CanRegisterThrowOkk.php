<?php

namespace jDev\OkkAuth;


trait CanRegisterThrowOkk
{

    public function getNameAttribute()
    {
        return (($this->last_name) ? $this->last_name : '') . ' '
            . (($this->first_name) ? $this->first_name : '');
    }

    public function getFullNameAttribute()
    {
        return (($this->last_name) ? $this->last_name : '') . ' '
            . (($this->first_name) ? $this->first_name : '') . ' '
            . (($this->middle_name) ? $this->middle_name : '');
    }

    public function addresses()
    {
        return $this->hasMany(\jDev\OkkAuth\Models\UserAddress::class);
    }

    public function getLivingAddressAttribute()
    {
        return $this->addresses->where('type', '=', \jDev\OkkAuth\Models\UserAddress::ADDRESS_TYPE_LIVING)->first();
    }

    public function getRegistrationAddressAttribute()
    {
        return $this->addresses->where('type', '=', \jDev\OkkAuth\Models\UserAddress::ADDRESS_TYPE_REGISTRATION)->first();
    }

    public function emails()
    {
        return $this->hasMany(\jDev\OkkAuth\Models\UserEmail::class);
    }

    public function emailsSystem()
    {
        return $this->emails()->where('type', '<>', \jDev\OkkAuth\Models\UserEmail::TYPE_MANUAL);
    }
    public function emailsAdditional()
    {
        return $this->emails()->where('type', '=', \jDev\OkkAuth\Models\UserEmail::TYPE_MANUAL);
    }

    public function getPrimaryEmailAttribute()
    {
        $email = $this->emails->where('type', \jDev\OkkAuth\Models\UserEmail::TYPE_PRIMARY)->first();
        if (!$email) $email = $this->emails->first();
        return $email;
    }

    public function phones()
    {
        return $this->hasMany('\jDev\OkkAuth\Models\UserPhone');
    }
    public function phonesSystem()
    {
        return $this->phones()->where('type', '<>', \jDev\OkkAuth\Models\UserPhone::TYPE_MANUAL);
    }
    public function phonesAdditional()
    {
        return $this->phones()->where('type', '=', \jDev\OkkAuth\Models\UserPhone::TYPE_MANUAL);
    }
}