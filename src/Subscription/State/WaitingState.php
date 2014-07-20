<?php
namespace Acme\Subscription\State;

class WaitingState implements SubscriberState {

    public $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function createSubscription()
    {
        echo 'event seats full';
    }

    public function cancelSubscription()
    {
        echo 'not subscribed at first place ';
    }
}