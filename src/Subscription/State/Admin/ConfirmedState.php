<?php namespace Acme\Subscription\State\Admin;

class ConfirmedState extends AbstractState implements SubscriberState {

    public $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function createSubscription()
    {
        if ( ! empty($this->subscriber->messages) ) {
            return false;
        }
        $this->subscriber->model->status = 'CONFIRMED';
        $this->subscriber->model->save();
    }

}