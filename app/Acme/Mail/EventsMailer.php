<?php namespace Acme\Mail;

use EventModel;

/**
 * Created by PhpStorm.
 * User: ZaL
 * Date: 2/14/14
 * Time: 3:51 PM
 */
class EventsMailer extends Mailer
{
    public function notifyFollowers(EventModel $model)
    {
        foreach ($model->followers as $follower) {
            $mail_to = $follower->email;
            $view = 'emails.welcome';
            $data = [];
            $subject = 'Hello ' . $follower->username;
//            var_dump($mail_to);
            $this->sendTo($mail_to, $subject, $view, $data);
        }
    }

}

