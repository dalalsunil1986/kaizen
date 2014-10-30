<?php
namespace Acme\Subscription\State;

class PaymentState extends AbstractState implements SubscriberState {

    public $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function createSubscription()
    {
        // check if the user has already paid to the event
        // if paid, set confirm state
        // if not, say the he cannot be confirmed before payment

        if($this->subscriber->model->paymentSuccess) {

            return $this->subscriber->setSubscriptionState($this->subscriber->getConfirmedState());

        } else {
            $this->subscriber->messages->add('errors','Payment Not Confirmed');
            return false;
        }

    }

    public function cancelSubscription()
    {
//        if($this->subscriber->model->paymentSuccess) {
//            // make the refund value
//            ($this->subscriber->model->paymentSuccess->user_id);                                    // delete the payment
//            $this->subscriber->model->delete(); // delete the subscription
//
//        } else {
//            // could not unsubscribe
//        }

    }

}