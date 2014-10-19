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
        $this->view           = 'emails.subscription';
        $this->recepientEmail = $user['email'];
        $this->recepientName  = $user['name_en'];
        $this->subject        = 'Kaizen Event Subscription' ;
        switch ( $user['status'] ) {
            case 'PENDING' :
                $user['body']  = 'Your Request for the event ' . $user['title'] . ' is awaiting for admin approval. You will be notified shortly ';
                break;
            case 'APPROVED' :
                $user['body']  = 'Your Request for the event ' . $user['title'] . ' is Approved, Please Confirm Your Subscription By ' . link_to_action('SubscriptionsController@confirmSubscription','Clicking this Link',[$user['event_id']]);
                break;
            case 'CONFIRMED' :
                $user['body']  = 'You have been confirmed to the event ' . $user['title'];
                break;
            case 'WAITING' :
                $user['body']  = 'You have been put on waiting list for the event ' . $user['title'];
                break;
            case 'REJECTED' :
                $user['body']  = 'Your Request to Subscribe event ' . $user['title'] .' has been rejected.';
                break;
            default :
                break;
        }
        // Send Email
        $this->fire($user);
    }


}