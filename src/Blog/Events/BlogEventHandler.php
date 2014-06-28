<?php namespace Acme\Blog\Events;

use Acme\Core\Mailers\AbstractMailer;
use User;
use Event;

class BlogEventHandler extends AbstractMailer {

    /**
     * @param array|\User $user
     * @internal param array $data Handle the* Handle the
     */
    public function handle(array $user)
    {
        if ( Event::firing() == 'blog.created' ) {

            return $this->sendActivationMail($user);
        }
    }

    public function sendActivationMail($user)
    {
        $this->view          = 'emails.auth.default';
        $this->recepientEmail     = $user['email'];
        $this->recepientName = $user['name_en'];
        $this->subject       = 'Please Activate Your Email';
        $user['body']        = 'To activate your Kuwaitii.com Account,<a href="' . action('AuthController@activate', $user['confirmation_code']) . '"> Click this link </a> ';

        // Send Email
        $this->fire($user);
    }


}