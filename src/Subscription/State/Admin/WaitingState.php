<?php namespace Acme\Subscription\State\Admin;


class WaitingState extends AbstractState implements SubscriberState {

    public $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function createSubscription()
    {
        $this->subscriber->messages->add('errors', 'Sorry, Seats are full. We have put you on Waiting List, Admin Will Soon Notify You');
        $this->subscriber->model->status = 'WAITING';
        $this->subscriber->model->save();
    }

}