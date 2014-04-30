<?php namespace Acme\Mail;
use Illuminate\Support\Facades\Mail;
use User;

/**
 * Created by PhpStorm.
 * User: ZaL
 * Date: 2/14/14
 * Time: 3:51 PM
 */

class UserMailer extends  Mailer {

    /**
     * @param $user
     * @param $args
     * @return mixed|void
     * //todo fix
     */
    public function sendMail($model,$args)
    {
        $view = 'emails.report';
        $args['subject'] = 'Kaizen.com, Report About User ' .$args['report_user_username'];
        //admin email
        if ($this->send($view,$args,$model)) {
            return true;
        };

    }
} 