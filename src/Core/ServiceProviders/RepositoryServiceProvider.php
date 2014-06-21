<?php namespace Acme\Core\ServiceProviders;

use Illuminate\Support\MessageBag;
use Acme\Users\AuthService;
use Acme\Users\EloquentAuthRepository;
use Acme\Users\UserEventSubscriber;
use Post;
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
        $this->app->bind('Kuwaitii\Users\UserRepository', function ($app) {
            $user = new EloquentUserRepository(new User);
            return $user;
            // return new CacheDecorator($user, new LaravelCache($app['cache'], 'user'));
        });

    }

    private function registerAuthService()
    {
        $this->app->bind('Kuwaitii\Users\AuthService', function ($app) {
//            $user = new AuthService();
            $user = new AuthService($app->make('Kuwaitii\Users\UserRepository'), new MessageBag);
//            $user = new EloquentAuthRepository(new User);

            $user->registerValidator(
                'create', $app->make('Kuwaitii\Users\Validators\UserCreateValidator')
            );

            $user->registerValidator(
                'update', $app->make('Kuwaitii\Users\Validators\UserUpdateValidator')
            );

            $user->registerValidator(
                'reset', $app->make('Kuwaitii\Users\Validators\UserResetValidator')
            );

            return $user;
        });
    }


}
