<?php namespace Acme\Mail;
use User;

/**
 * Created by PhpStorm.
 * User: ZaL
 * Date: 2/14/14
 * Time: 3:51 PM
 */

class UserMailer extends  Mailer {

    public function welcome(User $user) {
        $view = 'emails.welcome';
        $data = [];
        $subject = 'hey';
        return $this->sendTo($user, $subject, $view, $data);
    }

} 