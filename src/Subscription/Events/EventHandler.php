<?php namespace Acme\Subscription\Events;

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
        if ( Event::firing() == 'subscriptions.created' ) {
            return $this->sendSubscriptionMail($user);
        }
    }

    public function sendSubscriptionMail($user)
    {
        $this->view           = 'emails.subscriptions.default';
        $this->recepientEmail = $user['email'];
        $this->recepientName  = $user['name_en'];
        $this->subject        = 'Kaizen Event Subscription' ;
        switch ( $user['status'] ) {
            case 'PENDING' :
                $user['body']  = 'Your Request for the event ' . $user['title'] . ' is awaiting for admin approval. You will be notified shortly ';
                break;
            case 'APPROVED' :
                $user['body']  = 'Your Request for the event ' . $user['title'] . ' is Approved, Please Confirm Your Subscription ';
                break;
            case 'CONFIRMED' :
                $user['body']  = 'You have been confirmed to the event ' . $user['title'];
                break;
            default :
                break;
        }
        // Send Email
        $this->fire($user);
    }


}