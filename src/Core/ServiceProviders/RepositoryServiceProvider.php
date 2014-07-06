<?php namespace Acme\Core\ServiceProviders;

use Acme\Contact\ContactEventSubscriber;
use Acme\Users\UserEventSubscriber;
use Illuminate\Support\ServiceProvider;
use Acme\Users\EloquentUserRepository;

class RepositoryServiceProvider extends ServiceProvider {

    /**
     * Register
     */
    public function boot()
    {
        $this->app['events']->subscribe(new UserEventSubscriber($this->app['mailer']));
        $this->app['events']->subscribe(new ContactEventSubscriber($this->app['mailer']));
    }

    public function register()
    {

    }

}
