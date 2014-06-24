<?php namespace Acme\Users\Events;

use Acme\Core\Mailers\AbstractMailer;
use User;
use Event;

class UserEventHandler extends AbstractMailer {

    /**
     * @param array|\User $user
     * @internal param array $data Handle the* Handle the
     */
    public function handle(array $user)
    {
        if ( Event::firing() == 'user.created' ) {
            return $this->sendActivationMail($user);
        } elseif ( Event::firing() == 'user.reset' ){
            return $this->sendPasswordResetMail($user);
        }
    }

    public function sendActivationMail($user)
    {
        $this->view          = 'emails.auth.default';
        $this->recepient     =  $user['email'];
        $this->recepientName =  $user['name_en'];
        $this->subject       = 'Please Activate Your Email';
        $user['body']           = 'To activate your Kuwaitii.com Account,<a href="' . action('AuthController@activate', $user['confirmation_code']) . '"> Click this link </a> ';

        // Send Email
        $this->fire($user);
    }


//    public function sendActivationMail(User $user)
//    {
//        $this->view          = 'emails.auth.default';
//        $this->recepient     =  $user->email;
//        $this->recepientName =  $user->name;
//        $this->subject       = 'Please Activate Your Email';
//        $user->body           = 'To activate your Kuwaitii.com Account,<a href="' . action('AuthController@activate', $user->confirmation_code) . '"> Click this link </a> ';
//
//        // Send Email
//        $this->fire($user->toArray());
//    }


    private function sendPasswordResetMail(User $user)
    {
        $this->view          = 'emails.auth.default';
        $this->recepient     =  $user->email;
        $this->recepientName =  $user->name;
        $this->subject       = 'Please Reset Your Email';
        $user->body          = 'To Reset your Kuwaitii.com Password,<a href="' . action('AuthController@getReset', $user->confirmation_code) . '"> Click this link </a> ';

        // Send Email
        $this->fire($user->toArray());
    }
}