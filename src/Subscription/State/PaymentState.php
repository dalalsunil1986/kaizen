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
        dd('non admin payment');
        // check if the user has already paid to the event
        // if paid, set confirm state
        // if not, say the he cannot be confirmed before payment
        $this->subscriber->model->status = 'PAYMENT';
        $this->subscriber->model->save();

    }

    public function cancelSubscription()
    {

    }

}