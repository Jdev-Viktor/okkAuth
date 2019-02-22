<?php

namespace jDev\OkkAuth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Auth\AuthManager as Auth;

class OkkAuthController extends \App\Http\Controllers\Controller
{

    use AuthenticatesUsers;

    public function login()
    {
        return Socialite::driver('kyivID')->redirect();
    }

    public function loginAttempt()
    {
        return Socialite::driver('kyivID')->attempt();
    }

    public function loginCallback(Request $request)
    {
        try {
            $user = KyivIdUserResolver::resolve(
                Socialite::driver('kyivID')->user()
            );
        } catch (\Throwable $e) {
            throw $e;
        }

        if (!$user) {
            return redirect()->route('bad-login');
        }

        \Auth::login($user);

        return redirect('/', 302);
    }
}
