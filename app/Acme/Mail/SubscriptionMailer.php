<?php namespace Acme\Mail;
use Illuminate\Support\Facades\Mail;
use User;

/**
 * Created by PhpStorm.
 * User: ZaL
 * Date: 2/14/14
 * Time: 3:51 PM
 */

class SubscriptionMailer  extends  Mailer {

    /**
     * @param $user
     * @param $args
     * @return mixed|void
     * //todo fix
     */
    public function sendMail($model,$args)
    {
        $view = 'emails.subscription';
        $args['email'] = 'noreply@Kaizen.com';
        $args['name']  = 'noreply@Kaizen.com';

        //admin email
        if ($this->send($view,$args,$model)) {
            return true;
        };

    }
} 