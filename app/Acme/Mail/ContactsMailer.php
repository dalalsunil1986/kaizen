<?php namespace Acme\Mail;
use Redirect;
use User;

/**
 * Created by PhpStorm.
 * User: ZaL
 * Date: 2/14/14
 * Time: 3:51 PM
 */

class ContactsMailer extends  Mailer {

    /**
     * @param $model User
     * @param $args
     * @internal param $user
     * @return mixed|void
     * //todo fix
     */
    public function sendMail($model,$args)
    {
        $view = 'emails.contact';
        $args['subject'] = 'Kaizen.com '. $args['name'] .' has contacted you';
        if ($this->send($view,$args,$model)) {
            return true;
        };
    }

} 