<?php namespace Acme\Providers;

use Illuminate\Support\ServiceProvider;
use Acme\Mail\Blasts\MailchimpBlast;
use Mailchimp;

class EmailBlastServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Acme\Mail\Blasts\EmailBlastInterface', function()
        {
            $mc = new Mailchimp('107025e4b301304e9a4e226b1668b370-us3');

            return new MailchimpBlast($mc);
        });
    }
}
