<?php

namespace App\Providers;

use App\Repositories\AnswerGrammerRepository;
use App\Repositories\AnswerLevelRepository;
use App\Repositories\AppointmentRepository;
use App\Repositories\GrammerRepository;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;
use App\Services\AnswerGrammerService;
use App\Services\AnswerLevelService;
use App\Services\AppointmentService;
use App\Services\GrammerService;
use App\Services\OrderService;
use App\Services\UserService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UserRepository::class, function ($app) {
            return new UserRepository();
        });

        $this->app->singleton(UserService::class, function ($app) {

            return new UserService($app->make(UserRepository::class));
        });

        $this->app->singleton(AnswerGrammerRepository::class, function ($app) {
            return new AnswerGrammerRepository();
        });

        $this->app->singleton(AnswerGrammerService::class, function ($app) {

            return new AnswerGrammerService($app->make(AnswerGrammerRepository::class));
        });

        $this->app->singleton(AnswerLevelRepository::class, function ($app) {
            return new AnswerLevelRepository();
        });

        $this->app->singleton(AnswerLevelService::class, function ($app) {

            return new AnswerLevelService($app->make(AnswerLevelRepository::class));
        });

        $this->app->singleton(AppointmentRepository::class, function ($app) {
            return new AppointmentRepository();
        });

        $this->app->singleton(AppointmentService::class, function ($app) {

            return new AppointmentService($app->make(AppointmentRepository::class));
        });

        $this->app->singleton(GrammerRepository::class, function ($app) {
            return new GrammerRepository();
        });

        $this->app->singleton(GrammerService::class, function ($app) {

            return new GrammerService($app->make(GrammerRepository::class));
        });

        $this->app->singleton(OrderRepository::class, function ($app) {
            return new OrderRepository();
        });

        $this->app->singleton(OrderService::class, function ($app) {

            return new OrderService($app->make(OrderRepository::class));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Schema::defaultStringLength(191);
    }
}
