<?php namespace Acme\Mail;
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
    public function sendMail($user,$args) {
        $view = 'emails.welcome';
        $data = [];
        $subject = 'hey';
        return $this->send($user, $subject, $view, $data);
    }

} 