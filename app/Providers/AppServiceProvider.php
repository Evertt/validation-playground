<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\ThreadRepository::class, function($app) {
            // This is what Doctrine's EntityRepository needs in its constructor.
            return new \App\Repositories\ThreadRepository(
                $app['em'],
                $app['em']->getClassMetaData(\App\Entities\Thread::class)
            );
        });

        $this->app->bind(\App\Repositories\ChannelRepository::class, function($app) {
            // This is what Doctrine's EntityRepository needs in its constructor.
            return new \App\Repositories\ChannelRepository(
                $app['em'],
                $app['em']->getClassMetaData(\App\Entities\Channel::class)
            );
        });
    }
}
