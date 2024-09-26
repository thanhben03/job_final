<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    protected $services = [
        'App\Services\Career\CareerServiceInterface' => 'App\Services\Career\CareerService',
        'App\Services\Skill\SkillServiceInterface' => 'App\Services\Skill\SkillService',
        'App\Services\User\UserServiceInterface' => 'App\Services\User\UserService',

    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        foreach ($this->services as $interface => $implement) {
            $this->app->singleton($interface, $implement);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
