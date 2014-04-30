<?php namespace Acme\Mail;

use EventModel;
use Mail;

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
        $view = 'emails.welcome';
        foreach ($model->followers as $follower) {
            $mail_to = $follower->email;
            $data = [];
            $subject = 'Hello ' . $follower->username;
            $this->send($mail_to, $subject, $view, $data);
        }
    }

    public function sendMail($model,$args)
    {
        $view = 'emails.notify-followers';
        foreach ($model as $user) {
            $this->send($view,$args,$user);
        }
    }

}

