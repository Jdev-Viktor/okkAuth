<?php

Route::get('test', function(){
    dd(config('okk.kyivID.host'));
});
// Authentication Routes...
Route::get('login', '\jDev\OkkAuth\OkkAuthController@login')->name('login')->middleware('web', 'guest');
Route::get('auth/attempt', '\jDev\OkkAuth\OkkAuthController@loginAttempt')->middleware('web', 'guest');
Route::get('auth/callback', '\jDev\OkkAuth\OkkAuthController@loginCallback')->middleware('web', 'guest')->name('/auth/callback');
Route::post('logout', '\jDev\OkkAuth\OkkAuthController@logout')->name('logout')->middleware('web', 'auth');