<?php namespace Acme\Core\ServiceProviders;

use Illuminate\Support\MessageBag;
use Acme\Users\AuthService;
use Acme\Users\EloquentAuthRepository;
use Acme\Users\UserEventSubscriber;
use Illuminate\Support\ServiceProvider;
use Acme\Users\EloquentUserRepository;
use User;

class RepositoryServiceProvider extends ServiceProvider {

    /**
     * Register
     */
    public function boot()
    {
        $this->app['events']->subscribe(new UserEventSubscriber($this->app['mailer']));
    }

    public function register()
    {
        $this->registerUserRepository();
        $this->registerAuthService();
    }

    /**
     * Register User Repository
     */
    private function registerUserRepository()
    {
        $this->app->bind('Acme\Users\UserRepository', function ($app) {
            $user = new EloquentUserRepository(new User);

            $user->registerValidator(
                'update', $app->make('Acme\Users\Validators\UserUpdateValidator')
            );

            return $user;
        });

    }

    private function registerAuthService()
    {
        $this->app->bind('Acme\Users\AuthService', function ($app) {
            $user = new AuthService($app->make('Acme\Users\UserRepository'), new MessageBag);

            $user->registerValidator(
                'create', $app->make('Acme\Users\Validators\UserCreateValidator')
            );

            $user->registerValidator(
                'reset', $app->make('Acme\Users\Validators\UserResetValidator')
            );

            return $user;
        });
    }

}
