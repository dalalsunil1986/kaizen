<?php
namespace Acme\Subscription\State;

class WaitingState extends AbstractState implements SubscriberState {

    public $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function createSubscription()
    {
        $this->subscriber->repository->status = 'WAITING';
        $this->subscriber->repository->save();
        $this->subscriber->messages->add('errors', 'Seats are full, Sorry');
        $this->subscriber->messages->add('errors', 'Seats are full, Sorry again');
    }

}