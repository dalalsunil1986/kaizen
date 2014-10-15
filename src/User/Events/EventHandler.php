<?php namespace Acme\User\Events;

use Acme\Core\Mailers\AbstractMailer;
use User;
use Event;

class EventHandler extends AbstractMailer {

    /**
     * @param array|\User $user
     * @internal param array $data Handle the* Handle the
     */
    public function handle(array $user)
    {
        if ( Event::firing() == 'user.created' ) {

            return $this->sendActivationMail($user);
        } elseif ( Event::firing() == 'user.activated' ) {
            return $this->welcomeMail($user);
        } elseif ( Event::firing() == 'user.reset' ) {

            return $this->sendPasswordResetMail($user);
        }
    }

    public function sendActivationMail($user)
    {
        $this->view           = 'emails.auth.default';
        $this->recepientEmail = $user['email'];
        $this->recepientName  = $user['name_ar'];

        if ( $user['active'] == 1 ) {
            // When user gets activated
            $this->subject        = 'Welcome to Kaizen.company ';
            $user['body'] = 'Your Account has been created in Kaizen.company with email ' . $user['email'] . ' .You can <a href="' . action('AuthController@getLogin') . '">click here to login.</a>';
        } else {
            $this->subject        = 'Please Activate Your Email';
            $user['body'] = 'To activate your Kaizen Account,<a href="' . action('AuthController@activate', $user['confirmation_code']) . '"> Click this link </a> ';
        }

        // Send Email
        $this->fire($user);
    }

    public function welcomeMail($user)
    {
        $this->sendActivationMail($user);
    }

    private function sendPasswordResetMail(User $user)
    {
        $this->view           = 'emails.auth.default';
        $this->recepientEmail = $user->email;
        $this->recepientName  = $user->name;
        $this->subject        = 'Please Reset Your Email';
        $user->body           = 'To Reset your Kuwaitii.com Password,<a href="' . action('AuthController@getReset', $user->confirmation_code) . '"> Click this link </a> ';

        // Send Email
        $this->fire($user->toArray());
    }
}