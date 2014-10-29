<?php namespace Acme\Subscription\Events;

use Acme\Core\Mailers\AbstractMailer;
use User;
use Event;

class EventHandler extends AbstractMailer {

    /**
     * @param array|\User $array
     * @internal param array $data Handle the* Handle the
     */
    public function handle(array $array)
    {
        if ( Event::firing() == 'subscriptions.created' ) {

            return $this->sendSubscriptionMail($array);
        }
    }

    public function sendSubscriptionMail($array)
    {
        $this->view           = 'emails.subscription';
        $this->recepientEmail = $array['email'];
        $this->recepientName  = $array['name_en'];
        $this->subject        = 'Kaizen Event Subscription' ;
        switch ( $array['status'] ) {
            case 'PENDING' :
                $array['body']  = 'Your Request for the event ' . $array['title'] . ' is awaiting for admin approval. You will be notified shortly ';
                break;
            case 'APPROVED' :
                $array['body']  = 'Your Request for the event ' . $array['title'] . ' is Approved, Please Confirm Your Subscription By ' . link_to_action('SubscriptionsController@confirmSubscription','Clicking this Link',[$array['event_id']]);
                break;
            case 'CONFIRMED' :
                $array['body']  = 'You have been confirmed to the event ' . $array['title'];
                break;
            case 'WAITING' :
                $array['body']  = 'You have been put on waiting list for the event ' . $array['title'];
                break;
            case 'REJECTED' :
                $array['body']  = 'Your Request to Subscribe event ' . $array['title'] .' has been rejected.';
                break;
            case 'PAYMENT' :
                $array['body']  = 'Your Request to Subscribe event ' . $array['title'] .' has been Approved.' . link_to_action('PaymentsController@getPayment', 'Click this link For the Payment', [$array['event_id'],'token'=>$array['token']] );
                break;
            default :
                break;
        }
        // Send Email
        $this->fire($array);
    }


}