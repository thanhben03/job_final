<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $repositories = [
        'App\Repositories\Career\CareerRepositoryInterface' => 'App\Repositories\Career\CareerRepository',
        'App\Repositories\Skill\SkillRepositoryInterface' => 'App\Repositories\Skill\SkillRepository',
        'App\Repositories\User\UserRepositoryInterface' => 'App\Repositories\User\UserRepository',
        'App\Repositories\CareerDetail\CareerDetailRepositoryInterface' => 'App\Repositories\CareerDetail\CareerDetailRepository',
        'App\Repositories\CareerSkill\CareerSkillRepositoryInterface' => 'App\Repositories\CareerSkill\CareerSkillRepository',

    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        foreach ($this->repositories as $interface => $implement) {
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
