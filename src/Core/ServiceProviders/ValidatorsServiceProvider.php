<?php namespace Acme\Core\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Acme\Users\Validators\UserCreateValidator;

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

    }

}
