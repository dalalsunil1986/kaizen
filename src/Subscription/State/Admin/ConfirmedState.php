<?php namespace Acme\Subscription\State\Admin;

class ConfirmedState extends AbstractState implements SubscriberState {

    public $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function createSubscription()
    {
        if ( $this->subscriber->messages->has('errors') ) {
            return false;
        }

        $this->subscriber->model->status = 'CONFIRMED';
        $this->subscriber->model->save();
    }

}