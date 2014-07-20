<?php
namespace Acme\Subscription\State;

class RejectedState implements SubscriberState {


    public $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function createSubscription()
    {
        echo 'you cannot subscribe';
    }

    public function cancelSubscription()
    {
        echo 'not subscribed at first place ';
    }
}