<?php

namespace jDev\OkkAuth;

use Illuminate\Routing\UrlGenerator as URL;
use Illuminate\Support\ServiceProvider;

class OkkAuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/okk.php', 'services'
        );
        $this->app->make('jDev\OkkAuth\KyivIdProvider');
        $this->app->make('jDev\OkkAuth\KyivIdUserResolver');
        $this->app->make('jDev\OkkAuth\OkkAuthController');

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');

//        $this->publishes([
//            __DIR__.'/config/okk.php' => config_path('okk.php'),
//        ]);

        $this->bootKievIDSocialite();

        if(config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }

    private function bootKievIDSocialite()
    {
        $socialite = $this->app->make('Laravel\Socialite\Contracts\Factory');
        $socialite->extend(
            'kyivID',
            function ($app) use ($socialite) {
                $config = $app['config']['services.kyivID'];
                return $socialite->buildProvider(\jDev\OkkAuth\KyivIdProvider::class, $config);
            }
        );
    }
}
