<?php
namespace Acme\Subscription\State;

class ApprovedState implements SubscriberState {

    public $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function createSubscription()
    {
        // if free type directly subsribe
        // if paid .. check columns if the payment was successfull. subcribe.
        $this->subscriber->repository->status = 'CONFIRMED';
        $this->subscriber->repository->save();
        echo 'pending state';
    }

    public function cancelSubscription()
    {
        $this->subscriber->repository->delete();
        echo 'unsubcribed';
    }
}