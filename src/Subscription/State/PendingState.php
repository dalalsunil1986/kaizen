<?php
namespace Acme\Subscription\State;

class PendingState implements SubscriberState {

    public $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function createSubscription()
    {
        $this->subscriber->repository->status = 'PENDING';
        $this->subscriber->repository->save();
    }

    public function cancelSubscription()
    {
        $this->subscriber->repository->delete();
        echo 'unsubscribed';
    }
}