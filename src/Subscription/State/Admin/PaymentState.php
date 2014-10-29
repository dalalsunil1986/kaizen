<?php
namespace Acme\Subscription\State\Admin;

use App;

class PaymentState extends AbstractState implements SubscriberState {

    public $subscriber;

    public $payment;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function createSubscription()
    {
        $this->subscriber->model->status = 'PAYMENT';
        $token = md5(uniqid(mt_rand(), true));
//        dd($this->subscriber->model->payments);
        $payment = $this->subscriber->model->payments()->create(['user_id'=>$this->subscriber->model->user_id,'token'=>$token]);
        $this->subscriber->messages->add('token', $token);
        $this->subscriber->model->save();
    }

    public function cancelSubscription()
    {
    }

}