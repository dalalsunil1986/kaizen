<?php
namespace Acme\Subscription\State;

class ConfirmedState extends AbstractState implements SubscriberState{

    public $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function createSubscription()
    {
        'already subscribed';
    }

}