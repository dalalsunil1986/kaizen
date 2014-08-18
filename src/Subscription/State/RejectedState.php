<?php
namespace Acme\Subscription\State;

class RejectedState extends AbstractState implements SubscriberState {


    public $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function createSubscription()
    {
        echo 'you cannot subscribe';
    }

}