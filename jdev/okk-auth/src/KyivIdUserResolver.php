<?php

namespace jDev\OkkAuth;

use App\Models\UserEmail;
use App\Models\UserPhone;
use App\User;

class KyivIdUserResolver
{

    /**
     * @param \Laravel\Socialite\Two\User $user
     * @return User|null
     */
    public static function resolve($user):? User
    {
        if (!$user) return null;
        if (!$user->inn && !$user->passport) return null;
//        if (!$user->phones) return null;

        //Searching by external kievID
        $existUser = User::where('ext_id', '=', $user->ext_id)->first();

        //if not found - search by inn
        if (!$existUser) {
            $existUser = User::where('inn', '=', $user->inn)->first();
        }

        //if not found - search by passport
        if (!$existUser) {
            $existUser = User::where('passport', '=', $user->passport)->first();
        }

        if ($existUser) {

            $oldUser = clone $existUser;
            $existUser = self::update($existUser, $user);

        } else {
            $existUser = self::register($user);
        }

        return $existUser;
    }

    /**
     * @param \App\User $existing
     * @param \Laravel\Socialite\Two\User $user
     * @return \App\User|null
     */
    private static function update($existing, $user):? User
    {
        $existing->load(['addresses', 'emails', 'phones']);

        $emails = $user->emails;
        $phones = $user->phones;
        $address_living = $user->address_living;
        $address_registration = $user->address_registration;

        $existing->ext_id = $user->ext_id;
        $existing->first_name = $user->first_name;
        $existing->last_name = $user->last_name;
        $existing->middle_name = $user->middle_name;
        $existing->birthday = $user->birthday;
        $existing->inn = $user->inn;
        $existing->passport = $user->passport;
        $existing->gender = $user->gender;

        $existing->save();

        $old_addresses = $existing->addresses->pluck(0, 'id')->toArray();
        $old_emails = $existing->emails->pluck(0, 'id')->toArray();
        $old_phones = $existing->phones->pluck(0, 'id')->toArray();


        $key = self::updateAddress($existing, $address_living, KyivIdProvider::ADDRESS_TYPE_LIVING);
        if (array_key_exists($key, $old_addresses)) unset($old_addresses[$key]);

        $key = self::updateAddress($existing, $address_registration, KyivIdProvider::ADDRESS_TYPE_REGISTRATION);
        if (array_key_exists($key, $old_addresses)) unset($old_addresses[$key]);


        if($emails) {
            foreach ($emails as $email) {
                $key = self::updateEmail($existing, $email);
                if (array_key_exists($key, $old_emails)) unset($old_emails[$key]);
            }
        }

        if($phones) {
            foreach ($phones as $phone) {
                $key = self::updatePhone($existing, $phone);
                if (array_key_exists($key, $old_phones)) unset($old_phones[$key]);
            }
        }

        $existing->addresses()->whereIn('id', array_keys($old_addresses))->delete();
        $existing->emails()
            ->whereIn('id', array_keys($old_emails))
            ->where('type', '<>', \jDev\OkkAuth\Models\UserEmail::TYPE_MANUAL)
            ->delete();
        if($phones) {
            $existing->phones()
                ->whereIn('id', array_keys($old_phones))
                ->where('type', '<>', \jDev\OkkAuth\Models\UserPhone::TYPE_MANUAL)
                ->delete();
        }

        return $existing;
    }

    /**
     * @param \Laravel\Socialite\Two\User $user
     * @return \App\User|null
     */
    private static function register($user):? User
    {
        $emails = $user->emails;
        $phones = $user->phones;
        $address_living = $user->address_living;
        $address_registration = $user->address_registration;

        $newUser = new User();
        $newUser->ext_id = $user->ext_id;
        $newUser->first_name = $user->first_name;
        $newUser->last_name = $user->last_name;
        $newUser->middle_name = $user->middle_name;
        $newUser->birthday = $user->birthday;
        $newUser->inn = $user->inn;
        $newUser->passport = $user->passport;
        $newUser->gender = $user->gender;

        $newUser->save();

        self::updateAddress($newUser, $address_living, KyivIdProvider::ADDRESS_TYPE_LIVING);
        self::updateAddress($newUser, $address_registration, KyivIdProvider::ADDRESS_TYPE_REGISTRATION);

        if($emails) {
            foreach ($emails as $email) {
                self::updateEmail($newUser, $email);
            }
        }

        if($phones) {
            foreach ($phones as $phone) {
                self::updatePhone($newUser, $phone);
            }
        }

        return $newUser;
    }

    /**
     * @param \App\User $user
     * @param \App\Services\Geocoding\Address $address
     * @return bool
     */
    private static function updateAddress($user, $address, $type)
    {
        $res = $user->addresses()->updateOrCreate(array_merge(
            ['type' => $type],
            $address->toArray()
        ));
        return ($res) ? $res->id : 0;
    }

    /**
     * @param \App\User $user
     * @param array $email
     * @return bool
     */
    private static function updateEmail($user, $email)
    {
        if (array_key_exists('email', $email) && array_key_exists('type', $email)) {
            $res = $user->emails()->updateOrCreate([
                'email' => $email['email'],
                'type' => $email['type'] ?? \jDev\OkkAuth\Models\UserEmail::TYPE_ADDITIONAL,
            ]);
        }
        return ($res) ? $res->id : 0;
    }

    /**
     * @param \App\User $user
     * @param array $phone
     * @return bool
     */
    private static function updatePhone($user, $phone)
    {
        if (array_key_exists('phoneNumber', $phone) && array_key_exists('type', $phone)) {
            $res = $user->phones()->updateOrCreate([
                'phone' => $phone['phoneNumber'],
                'type' => $phone['type'] ?? \jDev\OkkAuth\Models\UserPhone::TYPE_ADDITIONAL,
            ]);
        }
        return ($res) ? $res->id : 0;
    }
}