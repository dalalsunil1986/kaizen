<?php
namespace Acme\Subscription\State\Admin;

class PaymentState extends AbstractState implements SubscriberState {

    public $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function createSubscription()
    {
        $this->subscriber->model->status = 'PAYMENT';
        $this->subscriber->model->save();
    }

    public function cancelSubscription()
    {
    }

}