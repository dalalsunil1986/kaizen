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

        if($this->subscriber->model->paymentSuccess) {

            return $this->subscriber->setSubscriptionState($this->subscriber->getConfirmedState());

        } else {
            $this->subscriber->messages->add('errors','Payment Not Confirmed');
            return false;
        }

    }

    public function cancelSubscription()
    {

        $this->subscriber->model->delete(); // delete the subscription
    }

}