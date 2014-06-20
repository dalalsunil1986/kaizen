<?php namespace Kuwaitii\Core\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Kuwaitii\Users\Validators\UserCreateValidator;
use Kuwaitii\Users\Validators\UserUpdateValidator;

class ValidatorsServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->registerUserValidation();
    }

    /**
     * Register User Validation
     */
    protected function registerUserValidation()
    {
        $this->app->bind('Kuwaitii\Users\UserCreateValidator', function ($app) {
            return new UserCreateValidator($app['validator']);
        });

        $this->app->bind('Cribbb\Users\UserUpdateValidator', function ($app) {
            return new UserUpdateValidator($app['validator']);
        });
    }

}
